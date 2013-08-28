<?php
class MusthaveController extends Controller
{

    public function init()
    {
        $this->layout='//layouts/test';
        parent::init();
    }

    public function actionIndex()
	{
	    $id=Yii::app()->request->getQuery('id');
        
        if (!isset($id))
            $id=141;
        
        $model=Item::model()->visible()->findByPk(array('id'=>':id', ':id'=>$id));
        
        if (!isset($model))
            throw new CHttpException(500, 'ID is not valid!' );        
        
        $this->render('index', array('model'=>$model));
	}
}