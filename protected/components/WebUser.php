<?php
  Class WebUser extends CWebUser
  {
    private $_identity;
    public $identityClass;

    public function init() {
        parent::init();
    }

    /**
     * Returns user model with all properties
     * @return array
     */
    public function getIdentity()
    {
        if ($this->id !== null && $this->_identity === null) {
            $this->_identity = CActiveRecord::model($this->identityClass)->findByPk($this->id);
        }
      return $this->_identity;
    }

    protected function afterLogin($fromCookie) {
        parent::afterLogin($fromCookie);

        Yii::app()->db->createCommand()->update('user', array(
           'lastLoginTime'=>new CDbExpression('NOW()'),
        ), 'id=:id', array(':id'=>$this->id));
    }
  }
?>
