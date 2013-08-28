<?php
class LogController extends Controller
{

	public function actionIndex()
	{
        ///Yii::log( 'enter to system log message', CLogger::LEVEL_ERROR, 'system'); 
        SysLogger::log( 'enter to system log message view', 'warning', 'restrict.area', array('email' => 'moneystream@mail.ru') );
        ///Yii::getLogger()->flush(true);
        ///Logging::logActivityNew() ;
        
		$this->render('index',array(
			///'filtersForm' => $filtersForm,
            ///'dataProvider'=>$dataProvider,
		));
	}
}