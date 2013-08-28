<?php
class ItemSizeController extends Controller
{
    //Todo: remove actions if they are not needed!!!
    
    /**
    * Actions used for admin module
    * block - block/unblock user
    * markAsDeleted sets user is_blocked db field value to '2' meaning
    * that the user is deleted but actually it remains in the database
    */
    function actions()
    {
        return array(
            'block' =>array(
                'class'=>'application.modules.admin.components.actions.BlockAction',
                'modelClass'=>'ItemSize',
                'message_block'=>Yii::t('infoMessages', 'Размер включен!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при включении азмера!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Размер выключен!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при выключении размера!'),
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass'=>'ItemSize',
                'message_mark'=>Yii::t('infoMessages', 'Размер удален!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении размера!'),
            )            
        );
    }     
    
	public function actionIndex()
	{
		$search=new ItemSize('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('ItemSize')))
            $search->attributes=Yii::app()->request->getQuery('ItemSize');

		$criteria=new CDbCriteria;
		$criteria->compare('t.title',$search->title,true);
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));

		$dataProvider=new ActiveDataProvider('ItemSize',array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>array('create_time'=>true),
				'sortVar'=>'sort',
			),
            'pagination'=>array(
                'pageVar'=>'page',
                'sizeVar'=>'size',
                'pageSize'=>Yii::app()->params['defaultPageSize'],
                'sizeOptions'=>Yii::app()->params['sizeOptions'],
            ),
		));

        if(!is_null(Yii::app()->request->getQuery('ajax')))
		{
			$this->renderPartial('_grid',array(
				'dataProvider'=>$dataProvider,
				'search'=>$search,
			));
		}
		else
		{
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'search'=>$search,
			));
		}
	}
}