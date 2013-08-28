<?php
/**
 * Controller file.
 *
 * @author Turanszky Sandor <o.turansky@gmail.com>
 * @link http://www.tursystem.com.ua/
 * @copyright Copyright &copy; 2012-2013 TurSystem Software Development
 * @license http://www.tursystem.com.ua/license/
 */  
 
class Controller extends CController
{
	public $breadcrumbs=array();
    
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + block, markAsDeleted',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('superadmin'),
            ),
            array('deny'),
        );
    }

    public function init()
    {
        CHtml::$afterRequiredLabel=' <span class="required" title="' . Yii::t('formGeneral', 'Это поле обязательно для заполнения') . '">*</span>';
        parent::init();
    }

    /**
     * Sets flash messages with desired key.
     *
     * @param $key indicates the type of the message.
     * @param $value sets the text value of the message.
     * @param $defaultValue set the default value. By default is Null
     */     
    public function setFlash($key, $value, $defaultValue=NULL)
    {
        Yii::app()->user->setFlash($key, $value, $defaultValue);
    }
    
     /**
     * Sets flash messages with predefined key = success.
     *
     * @param $key = success indicates the successful message.
     * @param $value sets the text value of the message.
     * @param $defaultValue set the default value. By default is Null
     */  
    public function setFlashSuccess($value, $defaultValue = null)
    {
        $this->setFlash('success', $value, $defaultValue);
    }
    
     /**
     * Sets flash messages with predefined key = alert.
     *
     * @param $key = alert indicates an alert message.
     * @param $value sets the text value of the message.
     * @param $defaultValue set the default value. By default is Null
     */     
    public function setFlashAlert($value, $defaultValue = null)
    {
        $this->setFlash('alert', $value, $defaultValue);
    }    
    
     /**
     * Sets flash messages with predefined key = error.
     *
     * @param $key = error indicates the error message.
     * @param $value sets the text value of the message.
     * @param $defaultValue set the default value. By default is Null
     */     
    public function setFlashError($value, $defaultValue = null)
    {
        $this->setFlash('error', $value, $defaultValue);
    }
    
    /**
     * Returns the data model based on the primary key given in the GET or POST variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $modelName - is used as a model name if passed
     */
    public function loadModel($modelName=null)
    {
        if($this->_model===null)
        {
            if (!is_null(Yii::app()->request->getQuery('id')))
                $id = Yii::app()->request->getQuery('id');
            elseif (!is_null(Yii::app()->request->getPost('id')))
                $id = Yii::app()->request->getPost('id');
            else
                throw new CHttpException(404, Yii::t('error', 'Страница не найдена'));
            
            $modelName = (is_null($modelName)) ? ucfirst(Yii::app()->controller->id) : ucfirst($modelName);
            $this->_model=CActiveRecord::model($modelName)->findByPk(array('id'=>':id', ':id'=>$id));
            
            if($this->_model===null)
                throw new CHttpException(404, Yii::t('error', 'Страница не найдена'));
        }
        return $this->_model;
    }
}