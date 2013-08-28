<?php
    /**
     * MarkAsDeleted sets the state of user to deleted
     * that is the user is not actually deleted but marked as deleted
     * by setting is_blocked = 2
     */ 
  class MarkAsDeletedForTreeAction extends CAction
  {
        public $pk = 'id';
        public $pks = 'ids';
        public $redirectTo = 'index';
        public $modelClass;
        public $message_mark;
        public $errorMessage_mark;
        protected $result=true;
        protected $ids=array();
        const MarkAsDeleted = 2;
      
        function run() {

            if(is_null(Yii::app()->request->getQuery($this->pk)) && is_null(Yii::app()->request->getQuery($this->pks)))
                throw new CHttpException(404);

            //if id is not null, assign it to ids array
            if(!is_null(Yii::app()->request->getQuery($this->pk)))
                $this->ids=array(Yii::app()->request->getQuery($this->pk));

            if(!is_null(Yii::app()->request->getQuery($this->pks)))
                $this->ids=Yii::app()->request->getQuery($this->pks);

            foreach($this->ids as $id)
            {
                $model=CActiveRecord::model($this->modelClass)->findByPk($id);
                $model->scenario='delete';

                if($model===null)
                    throw new CHttpException(404);

                $model->is_blocked = self::MarkAsDeleted;
                $this->result=$model->saveNode() && $this->result;
            }

            if($this->result)
            {
                $data['message'] = $this->message_mark;
                $this->controller->renderPartial('/layouts/messages/_message_success', $data, false, true);
            }
            else
            {
                $data['errorMessage'] = $this->errorMessage_mark;
                $this->controller->renderPartial('/layouts/messages/_message_error', $data, false, true);
            }

            if(!Yii::app()->request->isAjaxRequest)
                $this->redirect(array('index'));
        }
  }
  
?>
