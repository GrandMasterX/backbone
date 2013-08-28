<?php
class LoggController extends Controller
{

	public function actionIndex()
	{
        if (!isset($_POST['dateFrom'])) {
            $dateFrom = date("Y-m-d");
        } else {
            $dateFrom = "{$_POST['dateFrom']}";
        }
        
        if (!isset($_POST['dateTo'])) {
            $dateTo = date("Y-m-d");
        } else {
            $dateTo =  "{$_POST['dateTo']}";
        }

		$search=new Logging('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('Logging')))
            $search->attributes=Yii::app()->request->getQuery('Logging');

		$criteria=new CDbCriteria;
        //$criteria->compare('client.email', $search->client_search, true);
        //$criteria->compare('item.code', $search->item_code_search, true);
        //$criteria->compare('message', $search->message, true );
        //$criteria->compare('client_ip',$search->client_ip,true);
        $criteria->compare('t.os',$search->os,true);
        //$criteria->compare('browser',$search->browser,true);
        //$criteria->compare('browser_v',$search->browser_v,true);
        $criteria->compare('t.device',$search->device,true);
        $criteria->with = array('client', 'item');

        $criteria->condition = "
            logtime BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
            AND (session_id IS NULL OR workstage=(
            SELECT MAX(s2.workstage)
            FROM syslog s2
            WHERE t.session_id = s2.session_id))
        ";

        if (isset($_GET['level'])) {
            $level = $_GET['level'];
            if (in_array($level, array( 'error', 'warning', 'info', 'trace', 'profile'))) { //'all'
                $criteria->addCondition( "t.level = '$level'");
            }
        }

        $criteria->order = 'logtime DESC';
        $criteria->limit = 1000;


//        //echo "<pre><br>";    print_r($criteria->toArray() );     die;
//        $m = Logging::model()->findAll($criteria);
//        $n=  count($m);
//        //echo "<pre><br>$n<br>";
//        //print_r($criteria->toArray() );
//       foreach ($m as $w) {
//           $client = $w->client;      ///count ($w->client);  ->email
//           $item = count ($w->item);
//           if (count($client)) {
//                //echo " item=". print_r($w->item)." user=". print_r($client->attributes, true)."<br>";
//           }
//            //echo "item_id {$w->item->id} <br>";
//            //echo "id {$w->user->id} <br>";
//        }        ////echo count(logging)
////        die;
//        ///echo "<pre><br>";    print_r($cnt);  die;


        
        
        
        //$dependency = new CDbCacheDependency('SELECT MAX(logtime) FROM syslog');
        //$duration = 3600;

		$dataProvider=new ActiveDataProvider('Logging', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>array('logtime'=>true),
				'sortVar'=>'sort',
//                'attributes'=>array(
//                    'client_search'=>array(
//                        'asc'=>'user.email',
//                        'desc'=>'user.email DESC',
//                    ),
//                    'clientByEmail_search'=>array(
//                        'asc'=>'user.email',
//                        'desc'=>'user.email DESC',
//                    ),
//                    'item_code_search'=>array(
//                        'asc'=>'item.code',
//                        'desc'=>'item.code DESC',
//                    ),
//                    '*',
//                ),
			),
            'pagination'=>array(
                'pageVar'=>'page',
                'sizeVar'=>'size',
                'pageSize'=>Yii::app()->params['defaultPageSize'],
                'sizeOptions'=>Yii::app()->params['sizeOptions'],
            ),
		));
        


//       $filtersForm=new FiltersForm;
//        if (isset($_GET['FiltersForm']))
//            $filtersForm->filters=$_GET['FiltersForm'];

/* 
        $sql="
        SELECT t1.logtime, t1.message, t1.item_id, t1.client_ip, t1.country, t1.city, t1.device, t1.os, t1.browser, t1.browser_v, t2.code, t2.id, t3.email
        FROM (
        SELECT *
        FROM syslog s1
        WHERE session_id IS NOT NULL AND
            workstage=(SELECT MAX(s2.workstage)
            FROM syslog s2
            WHERE s1.session_id = s2.session_id)
        UNION
        SELECT *
        FROM syslog
        WHERE session_id IS NULL
        ) as t1
        LEFT JOIN item as t2 ON t1.item_id=t2.id
        LEFT JOIN user as t3 ON t1.client_id=t3.id
        ORDER BY logtime DESC
";      ///HAVING logtime BETWEEN '2013-08-15 15:28:40' AND '2013-08-15 15:48:40'


        $data=Yii::app()->db->createCommand($sql)->queryAll();
        $count= count($data);    ////Yii::app()->db->createCommand('SELECT COUNT(*) FROM log')->queryScalar();

        $filteredData=$filtersForm->filter($data);
        
        $dataProvider=new CArrayDataProvider($filteredData, array(
            'totalItemCount'=>$count,
            'sort'=>array(
            'defaultOrder'=>array('logtime'=>true),
                'attributes'=>array(
                     'logtime', 'message', 'client_ip', 'country', 'city', 'device', 'os', 'browser','browser_v', 'email', 'code',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));   */
        
        if(!is_null(Yii::app()->request->getQuery('ajax')))
		{
			$this->renderPartial('_grid',array(
                'level' => @$level,
//				'filtersForm' => $filtersForm,
                'dataProvider'=>$dataProvider,
                'search'=>$search,
			));
		}
		else
		{
			$this->render('index',array(
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'level' => @$level,
//				'filtersForm' => $filtersForm,
                'dataProvider'=>$dataProvider,
                'search'=>$search,
			));
		}
	}
    
    public function actionHistory() {    
        $days = Yii::app()->getRequest()->getParam('days');     //$days = Yii::app()->request->getQuery('days');

        $dateTo = date("Y-m-d");
        $dateFromDT = date_sub( new DateTime($dateTo), date_interval_create_from_date_string("$days days") );
        $dateFrom = date_format( $dateFromDT, "Y-m-d");

        echo json_encode( array( 'dateFrom'=>$dateFrom, 'dateTo'=>$dateTo));
//        die;
    }
    
    public function HistoryAjax( $days ) {
        return array(
            'type' => 'POST',
            'dataType'=>'json',
            'data'=>array(
                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                'days'=>"$days",
            ),
            'success' => "function( data ) {
                $('#dateFrom').val( data['dateFrom'] );
                $('#dateTo').val( data['dateTo'] );
            }",
        );
    }    


}