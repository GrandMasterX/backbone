<?php

class IndexController extends Controller {
    
     /**
     * @var string название атрибута, хранящего в себе имя файла и файл
     */
    public $attributeName='file';
    /**
     * @var array сценарии валидации к которым будут добавлены правила валидации
     * загрузки файлов
     */
    public $scenarios=array('insert','update');
    /**
     * @var string типы файлов, которые можно загружать (нужно для валидации)
     */
    public $fileTypes='doc,docx,xls,xlsx,odt,pdf';
    
    function actions() {
        return array(
                'block' => array(
                    'class' => 'application.modules.exel.components.actions.BlockAction',
                    'modelClass' => 'Index',
                    'message_block' => Yii::t('infoMessages', 'Пользователь разблокирован!'),
                    'errorMessage_block' => Yii::t('infoMessages', 'Произошла ошибка при разблокировании пользователя!'),
                    'message_unBlock' => Yii::t('infoMessages', 'Пользователь заблокирован!'),
                    'errorMessage_unBlock' => Yii::t('infoMessages', 'Произошла ошибка при блокировании пользователя!'),
                ),
                'markAsDeleted' => array(
                    'class' => 'application.modules.exel.components.actions.MarkAsDeletedAction',
                    'modelClass' => 'Index',
                    'message_mark' => Yii::t('infoMessages', 'Пользователь удален!'),
                    'errorMessage_mark' => Yii::t('infoMessages', 'Произошла ошибка при удалении пользователя!'),
                )
            );
    }
    
    public function actionIndex() {
        if(Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()
                ->controller
                ->createUrl('/register/index',array(
                    'code'=>Item::getRandomItemCode(),
                    )
                )
            );
        }
        $model = new Excel;
        $this->render(
            'index', 
            array(
                'model'=>$model
            )
        );
    }
    
    public function actionUpload()
    {
        $model=new Excel();
        if(isset($_POST['Excel']))
        {
            $model->scenario = 'insert';
            $model->attributes=$_POST['Excel'];
            Excel::model()->Excelsave();
            $this->render('index', array('model'=>$model));
        } else {
            $this->render('not_valid', array('model'=>$model));
        }
      
    }
    
}
?>
