<?php
/**
 * LogAnalyzerWidget class file.
 *
 * 
 * @author Stanislav Sysoev <d4rkr00t@gmial.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version 0.2
 */

class LogAnalyzerWidget extends CWidget {
    public $filters = array();

    public $log_file_path;

    public $title;

    private $last_status;
    private $load_media = 'file';   //'file';

    protected $_path = 'ext.loganalyzer.';

    public function init()
    {
        parent::init();

        Yii::import($this->_path.'LogAnalyzer');

        if (!$this->log_file_path) {
            $this->log_file_path = Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'application.log';
        }

        /**
         * Set widget title
         */
        if (!$this->title) {
            $this->title = Yii::t('LogAnalyzer.main', 'Log Analyzer');
        }

    }

    public function run()
    {
/*        if (isset($_GET['log'])) {
            file_put_contents($this->log_file_path, '');
            Yii::app()->controller->redirect($this->getUrl(false));
        }*/
/*
(   $logID,
    level VARCHAR(20) NOT NULL,
    category VARCHAR(255) NOT NULL,
    logtime datetime NOT NULL,
    message varchar(1023) NOT NULL,
    
    client_id int(11) DEFAULT NULL,
    email varchar(100) DEFAULT NULL,
    item_id int(11) DEFAULT NULL,
    session_id varchar(7) DEFAULT NULL,
    
    client_ip varchar(30) DEFAULT NULL,
    country varchar(20) DEFAULT NULL,
    city varchar(20) DEFAULT NULL,
    
    video_id varchar(127) DEFAULT NULL,
    video_title varchar(127) DEFAULT NULL,
    
    device varchar(127) DEFAULT NULL,
    os varchar(127) DEFAULT NULL,
    browser varchar(127) DEFAULT NULL,
    browser_v varchar(50) DEFAULT NULL,
    
    get_params varchar(255) DEFAULT NULL,
    post_params varchar(255) DEFAULT NULL,
    session_params varchar(255) DEFAULT NULL
*/

        if ($this->load_media =='db') {
            
            $log = Yii::app()->db->createCommand()
                ->select('*')
                ->from('syslog')
                ->limit(20)
                ->order("id DESC")
                ->queryAll();
                
                ///echo "<pre> LOG from Db <br>";       print_r($log);  die;
                
        } else {
            $log = file_get_contents($this->log_file_path);     // Load log file
            
            $log = explode('---', $log);        //Explode log on messages
            $pop = array_pop($log);
            $log = array_reverse($log);            
        }
        
        $this->registerAssets();

        $this->render('index', array(
            'log' => $log
        ));
    }

    /**
     * Register CSS and JS files.
     */
    protected function registerAssets() {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');

        $assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
        $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
        
        if (defined('YII_DEBUG')) {
            $cs->registerCssFile($url.'/log.css');
        } else {
            $cs->registerCssFile($url.'/log.min.css');
        }
    }


    public function filterLog($text)
    {
        foreach ($this->filters as $f) {
            if (preg_match('/'.$f.'/',$text)) {
                return false;
            }
        }

        return true;
    }

    public function showDate($text)
    {
        return date('H:i d.m.Y', strtotime(mb_substr($text, 0, 20,'utf8')));
    }

    public function showError($text)
    {
        $text = mb_substr($text, 20, mb_strlen($text,'utf8'),'utf8');

        $text = explode('Stack trace:', $text);
        $text = $text[0];

        if ($this->last_status != "") {
            $text = str_replace($this->last_status." ", "", $text);
        }

        return $text;
    }

    public function showStack($text)
    {
        $text = explode('Stack trace:', $text);
        return @$text[1];
    }

    public function showStatus($text)
    {
        if (preg_match('[error]',$text)) {
            $this->last_status = '[error]';
            return array('status'=>'error', 'class'=>'label-important');
        } elseif (preg_match('[warning]',$text)) {
            $this->last_status = '[warning]';
            return array('status'=>'warning', 'class'=>'label-warning');
        } elseif (preg_match('[info]',$text)) {
            $this->last_status = '[info]';
            return array('status'=>'info', 'class'=>'label-info');
        }else {
            return array('status'=>'undefined', 'class'=>'');
        }
    }

    public function getUrl($clear = true)
    {
        $url = '/';

        if (Yii::app()->controller->module) {
            $url .= Yii::app()->controller->module->getId().'/';
        }

        $url .= Yii::app()->controller->getId().'/'.Yii::app()->controller->getAction()->getId();

        if ($clear) {
            $url .= '/log/clear';
        }

        return Yii::app()->controller->createUrl($url);
    }
}