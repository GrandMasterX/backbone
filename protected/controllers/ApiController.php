<?php
class ApiController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl',
            //'ajaxOnly + getStatus',
        );
    }    
    
     public function actionGetStatus()    
     {
        $code=Yii::app()->request->getQuery('code'); 
        //$id=json_decode($_GET['id']);
        if (!isset($code))
            throw new CHttpException(500, 'Item code required!' );         
            
        $data=array();
        
        if (isset($code)) {
            $data = Yii::app()->db->createCommand()
                ->select('ready,unavailable')
                ->from('item')
                ->where('item.code=:code AND is_blocked=0', array(':code'=>$code))
                ->queryAll();
        }                
            
            if (empty($data))
                $data[0]['ready']=3;
            
            //if an item is unavailable (has a value 1), we have to set ready as 0 so that the button is not showed for this item
            if($data[0]['unavailable']==1)
                $data[0]['ready']=4;//item is unavailable    

            echo $_GET['callback'] . '(' . "{'state' : '".$data[0]['ready']."'}" . ')';
     }
}