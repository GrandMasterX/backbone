<?php
class LoggingController extends Controller
{

	public function actionIndex()
	{
//		$search=new Logging('search');
//		$search->unsetAttributes();

//        if(!is_null(Yii::app()->request->getQuery('Logging')))
//            $search->attributes=Yii::app()->request->getQuery('Logging');

//		$criteria=new CDbCriteria;
		//$criteria->compare('t.title',$search->title,true);
//        
//        $criteria->with = array('client', 'item');
//        $criteria->compare('client.email', $search->client_search, true);
//        $criteria->compare('client.email', $search->clientByEmail_search, true);
//        $criteria->compare('item.code', $search->item_code_search, true);
//        
//        $criteria->compare('action', $search->action, true );
//        $criteria->compare('client_ip',$search->client_ip,true);
//        $criteria->compare('os',$search->os,true);
//        $criteria->compare('browser',$search->browser,true);
//        $criteria->compare('browser_v',$search->browser_v,true); 
//        $criteria->compare('device',$search->device,true); 

//		$dataProvider=new ActiveDataProvider('Logging',array(
//			'criteria'=>$criteria,
//			'sort'=>array(
//				'defaultOrder'=>array('create_time'=>true),
//				'sortVar'=>'sort',
//                'attributes'=>array(
//                    'client_search'=>array(
//                        'asc'=>'client.email',
//                        'desc'=>'client.email DESC',
//                    ),
//                    'clientByEmail_search'=>array(
//                        'asc'=>'client.email',
//                        'desc'=>'client.email DESC',
//                    ),                    
//                    'item_code_search'=>array(
//                        'asc'=>'item.code',
//                        'desc'=>'item.code DESC',
//                    ),                    
//                    '*',
//                ),                
//			),
//            'pagination'=>array(
//                'pageVar'=>'page',
//                'sizeVar'=>'size',
//                'pageSize'=>Yii::app()->params['defaultPageSize'],
//                'sizeOptions'=>Yii::app()->params['sizeOptions'],
//            ),
//		));
        
        $filtersForm=new FiltersForm;
        if (isset($_GET['FiltersForm']))
            $filtersForm->filters=$_GET['FiltersForm'];        

        $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM log')->queryScalar();
        $sql='SELECT t1.action, t1.item_id, t1.client_ip, t1.country, t1.city, t1.device, t1.os, t1.browser, t1.browser_v, t1.create_time, t2.code, t2.id, t3.email FROM log as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id LEFT JOIN user as t3 ON t1.client_id=t3.id';
        $data=Yii::app()->db->createCommand($sql)->queryAll();

        $filteredData=$filtersForm->filter($data);
        
        $dataProvider=new CArrayDataProvider($filteredData, array(
            'totalItemCount'=>$count,
            'sort'=>array(
            'defaultOrder'=>array('create_time'=>true),
                'attributes'=>array(
                     'action', 'client_ip', 'country', 'city', 'device', 'os', 'browser','browser_v', 'create_time', 'email', 'code',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));        
        
        if(!is_null(Yii::app()->request->getQuery('ajax')))
		{
			$this->renderPartial('_grid',array(
				'filtersForm' => $filtersForm,
                'dataProvider'=>$dataProvider,
			));
		}
		else
		{
			$this->render('index',array(
				'filtersForm' => $filtersForm,
                'dataProvider'=>$dataProvider,
			));
		}
	}
}