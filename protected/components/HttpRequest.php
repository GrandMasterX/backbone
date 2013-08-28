<?php
  class HttpRequest extends CHttpRequest
  {
    public $noCsrfValidationRoutes=array();
    private $_csrfToken;
      
    /**
     * Returns the named GET parameter value.
     * CHtml::encode() used to clear XSS
     */
    public function getQuery($name,$defaultValue=null)
    {
        if (isset($_GET[$name]) && !is_array($_GET[$name]))
            return CHtml::encode($_GET[$name]);
        else 
            //Todo: array processing
            return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;    
    } 
    
    /**
     * Returns the named POST parameter value.
     * CHtml::encode() used to clear XSS
     */
    public function getPost($name,$defaultValue=null)
    {
        if (isset($_POST[$name]) && !is_array($_POST[$name]))
            return CHtml::encode($_POST[$name]);
        else
            //Todo: array processing
            return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }
    
        protected function normalizeRequest()
        {
                parent::normalizeRequest();
                if($this->enableCsrfValidation)
                {
                        $url=Yii::app()->getUrlManager()->parseUrl($this);
                        foreach($this->noCsrfValidationRoutes as $route)
                        {
                                if(strpos($url,$route)===0)
                                        Yii::app()->detachEventHandler('onBeginRequest',array($this,'validateCsrfToken'));
                        }
                }
        }
        
        public function getCsrfToken()
        {
            if($this->_csrfToken===null)
            {
                $session = Yii::app()->session;
                $csrfToken=$session->itemAt($this->csrfTokenName);
                if($csrfToken===null)
                {
                    $csrfToken = sha1(uniqid(mt_rand(),true));
                    $session->add($this->csrfTokenName, $csrfToken);
                }
                $this->_csrfToken = $csrfToken;
            }
         
            return $this->_csrfToken;
        }
        
        public function validateCsrfToken($event)
        {
            if($this->getIsPostRequest())
            {
                // only validate POST requests
                $session=Yii::app()->session;
                if($session->contains($this->csrfTokenName) && isset($_POST[$this->csrfTokenName]))
                {
                    $tokenFromSession=$session->itemAt($this->csrfTokenName);
                    $tokenFromPost=$_POST[$this->csrfTokenName];
                    $valid=$tokenFromSession===$tokenFromPost;
                }
                else
                    $valid=false;
                if(!$valid)
                    throw new CHttpException(400,Yii::t('yii','The CSRF token could not be verified.'));
            }
        }        
  }
?>
