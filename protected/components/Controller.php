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
	private $_pageKeywords;
	private $_pageDescription;
    
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();    
    
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;      
    

    public function init()
    {
        CHtml::$afterRequiredLabel=' <span class="required" title="' . Yii::t('formGeneral', 'Это поле обязательно для заполнения') . '">*</span>';
        parent::init();
    }   
    
	public function getPageKeywords()
	{
		return $this->_pageKeywords;
	}

	public function setPageKeywords($value)
	{
		$this->_pageKeywords=$value;
	}

	public function getPageDescription()
	{
		return $this->_pageDescription;
	}

	public function setPageDescription($value)
	{
		$this->_pageDescription=$value;
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
    
    /**
    * Use this code for ajax validation for CActiveForm
    * //If it is ajax validation request
    * change-pass-form stands for form id
    * if(isset($_POST['ajax']) && $_POST['ajax']==='change-pass-form') {
    *     $this->performAjaxValidation($model);
    * }
    */
    public function performAjaxValidation($model) {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
    
    /**
    * Use this code for ajax validation for CActiveForm
    * //If it is ajax validation request
    * change-pass-form stands for form id
    * if(isset($_POST['ajax']) && $_POST['ajax']==='change-pass-form') {
    *     $this->performAjaxValidation($model);
    * }
    */

    /**
    * NOTE!!!!
    * Tere is a problem using ajax validation with CHtml::ajaxSubmitButton
    * That is why an error array is treturned only on errors.
    * If no errors - nothing returned
    * 
    * @param mixed $model
    */

    public function performAjaxValidationOnError($model) {
        $error=CActiveForm::validate($model);
        if($error!='[]')
        {
            echo $error;
            Yii::app()->end();         
        }
    }      
    
    /**
    * Ajax validates multiple models
    * Use this code for a multiple ajax validation for CActiveForm
    * //If it is ajax validation request
    * change-pass-form stands for form id
    * if(isset(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='change-pass-form') {
    *     $this->performMultipleModelAjaxValidation(array($model, $translation)); 
    * }
    */
    public function performMultipleModelAjaxValidation($models=array()) {
        echo CActiveForm::validate($models);
        Yii::app()->end();
    }
    
        /**
        * auth user on page load without asking login/pass
        */
     public function authenticateOnLoginByHash() { 
        $id=Yii::app()->request->getQuery('id');
        $ucode=Yii::app()->request->getQuery('ucode');
        if(!is_null($id) && !is_null($ucode)) 
        {
            $user=User::model()->findByPk(array('id'=>':id', ':id'=>$id));
            if($user !== null && $user->email_hash == $ucode)
            {
                $user->authenticateOnLoginByHashFromEmail();
                Yii::app()->user->login($user,Yii::app()->params['loginDuration']);
            }
        }                          
     }
     /**
     * log user activity from emails sent
     * @param mixed $type = activity code
     */
     public function logFromEmailActivity($type)
     {
        $result=false;
        if(!Yii::app()->user->isGuest) 
        {
            $id=Yii::app()->request->getQuery('id');
            $ucode=Yii::app()->request->getQuery('ucode');
            if(!is_null($id) && !is_null($ucode)) 
            {
                $user=User::model()->findByPk(array('id'=>':id', ':id'=>$id));
                if($user !== null && $user->email_hash == $ucode)
                {
                    $data['email'] = $user->email;
                    $data['code'] = Yii::app()->request->getQuery('code');
                    $result=Logging::logActivity($user, $type, false, $data);   
                }
            }         
        }
        return $result;    
     }
     
}