<?php
    /**
     * MarkAsDeleted sets the state of user to deleted
     * that is the user is not actually deleted but marked as deleted
     * by setting is_blocked = 2
     */ 
  class MarkAsDeletedAction extends CAction
  {
        public $pk = 'id';
        public $redirectTo = 'index';
        public $modelClass;
        public $message_mark;
        public $errorMessage_mark;
        public $withImages = false;
        const MarkAsDeleted = 2;
      
        function run() {

            if(is_null(Yii::app()->request->getQuery($this->pk)))
                throw new CHttpException(404);
                
            $model=CActiveRecord::model($this->modelClass)->findByPk(Yii::app()->request->getQuery($this->pk));
            $model->scenario='delete';

            if($model===null)
                throw new CHttpException(404);

            $model->is_blocked = self::MarkAsDeleted;
            //sets images belongs ti null
            if ($this->withImages)
                $model->markImagesAsDeleted();
            
            $data['message'] = $this->message_mark;
            $data['errorMessage'] = $this->errorMessage_mark; 

            if($model->save(false))
                $this->controller->renderPartial('/layouts/messages/_message_success', $data, false, true);
            else
                $this->controller->renderPartial('/layouts/messages/_message_error', $data, false, true);

            if(is_null(Yii::app()->request->getQuery('ajax')))
                $this->redirect(array('index'));              
        }
  }
  
?>
