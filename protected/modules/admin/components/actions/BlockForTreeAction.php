<?php
    /**
     * BlockAction sets the state of user to blocked or unblocked
     * @param $id contains entity id.
     */ 

  class BlockForTreeAction extends CAction
  {
        public $pk = 'id';
        public $pks = 'ids';
        public $redirectTo = 'index';
        public $modelClass;
        public $message_block;
        public $errorMessage_block;
        public $message_unBlock;
        public $errorMessage_unBlock;
        protected $result=true;
        protected $ids=array();
        const BLOCKED = true;
        const UNBLOCKED = false;
      
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

                $this->result=$model->saveNode(array('is_blocked')) && $this->result;
            }

            if($this->result)
                $this->controller->renderPartial('/layouts/messages/_message_success', $data, false, true);
            else
                $this->controller->renderPartial('/layouts/messages/_message_error', $data, false, true);

            if(!Yii::app()->request->isAjaxRequest)
                $this->redirect(array('index'));              
        }
  }
