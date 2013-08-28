<?php
/**
 * DBLogRoute class file.
 * 
 * @author Tarasenko Andrew <moneystream@mail.ru>
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version 0.1
 */
class DbLogRoute extends CDbLogRoute
{
    public $connectionID='db';
    public $logTableName='syslog';
    public $autoCreateLogTable=true;
    private $_db; 
    
    
    /**
     * Formats a log message given different fields.
     * @param string $message message content
     * @param integer $level message level
     * @param string $category message category
     * @param integer $time timestamp
     * @return string formatted message
     */
    protected function formatLogMessage($message,$level,$category,$time)
    {
        return @date('Y/m/d H:i:s',$time)." [ip:".$ip."] [$level] [$category] $message\n";
/*        $ip = @Helper::getClientIP();   //$this->get_ip();
        if ($ip) {
            return @date('Y/m/d H:i:s',$time)." [ip:".$ip."] [$level] [$category] $message\n";
        } else {   */
        ///    parent::formatLogMessage($message, $level, $category, $time);
        ///}
    }

     /**
     * Initializes the route.
     * This method is invoked after the route is created by the route manager.
     */
    public function init() {
        parent::init();

        if($this->autoCreateLogTable) {   
            $db=$this->getDbConnection();
            
            $sql="DELETE FROM {$this->logTableName} WHERE 0=1";
            try {$db->createCommand($sql)->execute();
                } catch(Exception $e) {
                    $this->createLogTable($db,$this->logTableName);
                }
        }
    }
    
    /**
     * Creates the DB table for storing log messages.
     * @param CDbConnection $db the database connection
     * @param string $tableName the name of the table to be created
     */
    protected function createLogTable($db,$tableName) {
        $driver=$db->getDriverName();
        if($driver==='mysql')
            $logID='id int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY';      ///'id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY';        
        else if($driver==='pgsql')
            $logID='id SERIAL PRIMARY KEY';
        else {
            $logID='id INTEGER NOT NULL PRIMARY KEY';
        }

        $sql="
CREATE TABLE $tableName
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
    comment varchar(255) DEFAULT '_',
    video_id varchar(127) DEFAULT NULL,
    video_title varchar(127) DEFAULT NULL,
    workstage int(11) DEFAULT NULL,
    device varchar(127) DEFAULT NULL,
    os varchar(127) DEFAULT NULL,
    browser varchar(127) DEFAULT NULL,
    browser_v varchar(50) DEFAULT NULL,
    get_params varchar(512) DEFAULT NULL,
    post_params varchar(512) DEFAULT NULL,
    session_params varchar(512) DEFAULT NULL,
    KEY logtime (logtime),
    KEY workstage (workstage)
) ENGINE=MyISAM";       ///UNIQUE KEY workstage (workstage),

        $db->createCommand($sql)->execute();
    }

    /**
     * @return CDbConnection the DB connection instance
     * @throws CException if {@link connectionID} does not point to a valid application component.
     */
    protected function getDbConnection()
    {
        if($this->_db!==null) 
            return $this->_db;
        else if(($id=$this->connectionID)!==null)
        {
            if(($this->_db=Yii::app()->getComponent($id)) instanceof CDbConnection)
                return $this->_db;
            else
                throw new CException(Yii::t('yii','CDbLogRoute.connectionID "{id}" does not point to a valid CDbConnection application component.',
                    array('{id}'=>$id)));
        } else {
            $dbFile=Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'log-'.Yii::getVersion().'.db';
            return $this->_db=new CDbConnection('sqlite:'.$dbFile);
        }
    }

    /**
    * Formats a log message given different fields.
    * @param string $message message content
    * @param integer $level message level
    * @param string $category message category
    * @param integer $time timestamp
    * @return string formatted message
    */
    /*protected function formatLogMessage($message,$level,$category,$time)
    {
        return @date('Y/m/d H:i:s',$time)." [$level] [$category] $message\n";
    } */   
    
    /**
     * Stores log messages into database.
     * @param array $logs list of log messages
     */
    protected function processLogs($logs)
    {   ///echo "<pre>DbLogRoute processLogs <br>"; print_r($logs); die;
        $sql="
INSERT INTO {$this->logTableName}
(level, category, logtime, message,
client_id, email, item_id, session_id,
client_ip, country, city,
video_id, video_title, workstage,
device, os, browser, browser_v,
get_params, post_params, session_params 
) VALUES
(:level, :category, :logtime, :message,
:client_id, :email, :item_id, :session_id,
:client_ip, :country, :city,
:video_id, :video_title, :workstage,
:device, :os, :browser, :browser_v,
:get_params, :post_params, :session_params 
)";
        $command=$this->getDbConnection()->createCommand($sql);

        foreach($logs as $log)
        {
            $command->bindValue(':level', $log[1]);
            $command->bindValue(':category', $log[2]);                              /// ." DbLogRoute" 
            $command->bindValue(':logtime', date('Y/m/d H:i:s', (int)$log[3]) );   ///  '2013-07-07 12:00:00'  , (int)$log[3]
            $command->bindValue(':message', $log[0]);

            $command->bindValue(':client_id', @$log['client_id']);
            $command->bindValue(':email',     @$log['email']);
            $command->bindValue(':item_id',   @$log['item_id']);
            $command->bindValue(':session_id',@$log['session_id']);
            
            $command->bindValue(':client_ip', @$log['client_ip']);
            $command->bindValue(':country',   @$log['country']);
            $command->bindValue(':city',      @$log['city']);
            
            $command->bindValue(':video_id',   @$log['video_id']);
            $command->bindValue(':video_title',@$log['video_title']);
            $command->bindValue(':workstage',   @$log['workstage']);
            
            $command->bindValue(':device',    @$log['device']);
            $command->bindValue(':os',        @$log['os']);
            $command->bindValue(':browser',   @$log['browser']);
            $command->bindValue(':browser_v', @$log['browser_v']);
            
            $command->bindValue(':get_params', @$log['get_params']);
            $command->bindValue(':post_params',@$log['post_params']);
            $command->bindValue(':session_params', @$log['session_params']);
            
            $command->execute();
        }
    }
}
