<?php
    /**
     * BlockAction sets the state of user to blocked or unblocked
     * @param $id contains entity id.
     */ 

  class BlockForTreeAction extends CAction
  {
        public $pk = 'id';
        public $redirectTo = 'index';
        public $modelClass;
        public $message_block;
        public $errorMessage_block;
        public $message_unBlock;
        public $errorMessage_unBlock;          
        const BLOCKED = true;
        const UNBLOCKED = false;
      
        function run() {

            if(is_null(Yii::app()->request->getQuery($this->pk)))
                throw new CHttpException(404);
                
            $model=CActiveRecord::model($this->modelClass)->findByPk(Yii::app()->request->getQuery($this->pk));
            $model->scenario='block';

            if($model===null)
                throw new CHttpException(404);

            switch ($model->is_blocked)
            {
                case self::BLOCKED:
                $model->is_blocked = self::UNBLOCKED;
                $data['message'] = $this->message_block;
                $data['errorMessage'] = $this->errorMessage_block;                 
                break; 
                
                case self::UNBLOCKED:
                $model->is_blocked = self::BLOCKED;
                $data['message'] = $this->message_unBlock;
                $data['errorMessage'] = $this->errorMessage_unBlock;                
                break; 
            }     
            
            if($model->saveNode(array('is_blocked')))
                $this->controller->renderPartial('/layouts/messages/_message_success', $data, false, true);
            else
                $this->controller->renderPartial('/layouts/messages/_message_error', $data, false, true);

            if(is_null(Yii::app()->request->getQuery('ajax')))
                $this->redirect(array('index'));              
        }
  }
  
?>
