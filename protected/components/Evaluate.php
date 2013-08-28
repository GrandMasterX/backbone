<?php
  /**
  * This class is for evaluating sutable item size
  * for users based on item and user properties
  * 
  * The followings are the available properties and methods:
  * @property array $itemProperties
  * @property array $clientProperties
  * @property array $rangeProperties
  * @property array $formulasValue
  * @property array $resultArray
  * @property array $itemId
  * @property array $itemTypeId
  * @property array $clientId
  * @property array $serviceKey
  * @property array $serviceValue
  * @property array $errorReplacements
  * @property array $clientS
  * @property array $itemS 
  */
  class Evaluate extends CApplicationComponent //CComponent 
  {
       protected $itemProperties;
       protected $clientProperties;
       protected $rangeProperties;
       protected $rangePropertiesSum;
       protected $formulasValue;
       protected $rangeFormulas;
       protected $replacement;
       protected $sizeList;
       protected $resultArray=array();
       protected $itemId;
       protected $itemTypeId;
       protected $clientId;
       protected $serviceKey;
       protected $serviceValue;
       protected $errorReplacements;
       protected $preFinalResult;
       protected $finalResult;
       protected $recSize;
       protected $fullyFittedSizeList;
       protected $semiFittedSizeList;
       protected $notFittedSizeList;
       protected $idealSize=0;
       protected $idealSizeTight=0;
       protected $idealSizeBaggy=0;
       protected $sizeFitting=0;
       protected $even;
       protected $clientS=array(
            'vst'=>'Вшт',
            'vk'=>'Вк',
            'vzu'=>'ВЗУ',
            'dts'=>'ДТС',
            'dr'=>'Дрз',
//            'vpl'=>'Впл',
//            'vlok'=>'Влок',
//            'vprch'=>'ВпрЧ',
//            'drvnch'=>'ДРвнЧ',
        );
       protected $itemS=array(
            'il'=>'ДИ',
            'iwa'=>'ШУГ',
            'iww'=>'ШУТ',
            'iwt'=>'ШУБ',
            'ils'=>'ДР',
            'iws'=>'ШР',
            'iwp'=>'ШГ',
            'iwss'=>'Дбш',
            'iwcb'=>'Вп',
            'bw'=>'Шс',
            'vpr'=>'Впр',
            'rpli'=>'РплИ',
            'iwar'=>'ШУГР',
            'iwwr'=>'ШУТР',
            'stretch'=>'МНТ',
        );
        /**
        * When this array is changed, the same one should also be changed in models/ResFormulaTitle.php
        * @var mixed
        */
        protected $rangeList=array(
            '1'=>'СТ',
            '2'=>'СГ',
            '3'=>'СБ',
            '4'=>'ОП',
            '5'=>'ШГ',
            '6'=>'РП',        
        );
        /**
        * This range short titles are used to determine those range formulas that account for a size to be fully recommended.
        * If a size occurs recommended on this size titles, then this size is fully recommended.
        * @var mixed
        * TODO: this is dependent on item type(model). It should be populate depending  on the size list, that is set as obligatory for a certain type
        */
        protected $useRangeList  = array();
        protected $entryNeededNotLessThan=1;
        
        const VERY_TIGHT_PLUS  = "very_tight_plus";
        const VERY_TIGHT       = "very_tight";
        const RECOMENDED       = "recomended";
        const SEMI_RECOMENDED  = "semi_recomended";
        const BAGGY            = "baggy";
        const BAGGY_PLUS       = "baggy_plus";
        const NOT_FITTED       = "not_fitted";
        const UNDEFINED        = "undefined";
            
       function __construct($itemID,$itemTypeId, $clientId) //$itemID=264,$itemTypeId=48, $clientId=6 - $itemID=123,$itemTypeId=85, $clientId=6
       {
        if (isset($itemID) && !is_null($itemID))
            $this->itemId=$itemID;
                
        if (!isset($itemTypeId))
            throw new CHttpException(500, 'ItemType id required!' );              
           
           $this->itemTypeId=$itemTypeId;

        if (!isset($clientId))
            throw new CHttpException(500, 'User data required!' );              
            
           $this->clientId=$clientId;
           
           $this->init();
           if (isset($itemID) && !is_null($itemID))
                $this->replaceValues();
       }
       
       /**
       * Replaces formula placeholders with appropriate values
       */
       protected function replaceValues()
       {
           foreach($this->formulasValue as $key=>$fvalue) 
           {
               //$fvalue['value']=mb_strtoupper($fvalue['value'], 'utf-8');
               preg_match_all('/\{([^}]+)\}/', $fvalue['value'], $matches);
               foreach($this->sizeList as $size) 
               {
                   $this->replacement=array();
                   //$stag=mb_strtoupper($size.'_'.substr(substr($fvalue['tag'],0,-1),1), 'utf-8');
                   $stag=$size.'_'.substr(substr($fvalue['tag'],0,-1),1);
                   foreach($matches[1] as $match) 
                   {
                       //$match=mb_strtoupper($match, 'utf-8');
                       if(isset($this->itemProperties[$size . '_' . $match])) 
                           $this->replacement[$size . '_' . $match]=$this->itemProperties[$size . '_' . $match];
                       elseIf(isset($this->clientProperties[$match]))
                           $this->replacement[$match]=$this->clientProperties[$match];
                       elseIf(isset($this->resultArray[$size . '_' . $match]))
                           $this->replacement[$size . '_' . $match]=$this->resultArray[$size . '_' . $match];
                       else 
                            $this->errorReplacements[$size . '_' . $match]=$size . '_' . $match;
                   }
                   
                   
//                   echo 'errorReplacements START';
//                        Helper::myPrint_r($this->errorReplacements);
//                   echo 'errorReplacements END';
                   //calculates the equitation. But it should not be called unless all the values are replaced
                   $matches[0]=array_unique($matches[0]);
                   $matches[1]=array_unique($matches[1]);
//                   echo 'STAG: ' . $stag . "<br />";
//                   echo 'Fvalue: ' . $fvalue['value'] . "<br />";
//                   if($matches[1][0]=='РПЛ')
//                    echo 'Yes РПЛ' . '<br />';
                   if((isset($matches[1][1])) && $matches[1][1]=='РПЛИ') {
//                    echo 'Yes РПЛИ' . '<br />';                    
//                    echo 'value:' . $this->replacement[$size . '_РПЛИ'];
//                   
//                   echo "<br />";
//                   echo str_replace($matches[0], $this->replacement, $fvalue['value']);
//                   echo "<br />";
                   
  //                 foreach($matches[0] as $m)
//                   {
//                       echo 'ttt';
//                       echo "<br />";
//                       echo "<br />";
                       //echo preg_replace('/'.$m.'/', 777, $fvalue['value']);
//                       echo str_replace($matches[0], 777, $fvalue['value']);
//                       echo "<br />";
//                   }
                   

                   //$exp=preg_replace($matches[0], $this->replacement, $fvalue['value']);
                       $exp=str_replace($matches[0], $this->replacement, $fvalue['value']);
                       //echo 'ERROR COUNT: ' . count($this->errorReplacements) . '<br />';
                       
//                       if(count($this->errorReplacements) > 0) {
//                            echo CJavaScript::encode($this->itemId);
//                            Yii::app()->end();
//                       }
                             
                        
                       $this->resultArray[$stag]=(count($this->errorReplacements) > 0) 
                            ? str_replace($exp)
                            : $this->calculate($exp);
                   
                   } else
                   {
                       $this->resultArray[$stag]=(count($this->errorReplacements) > 0) 
                            ? str_replace($matches[0], $this->replacement, $fvalue['value'])
                            : $this->calculate(str_replace($matches[0], $this->replacement, $fvalue['value']));                       
                   }
                    
                    
                    //echo '<br />' . "STAG:" . $this->resultArray[$stag] . '<br />';

                         
                            //preg_replace($matches[0], $this->replacement, $fvalue['value'])
                            //str_replace($matches[0], $this->replacement, $fvalue['value'])

//                       Helper::myPrint_r($matches[0]);
//                       Helper::myPrint_r($matches[1]);
//                       Helper::myPrint_r($this->replacement);          
//                       echo 'fvalue' . $fvalue['value'] . '<br />';
//                       echo 'val: ' . preg_replace($matches[0], $this->replacement, $fvalue['value']). '<br />';
//                       echo 'val: ' . str_replace($matches[1], $this->replacement, $fvalue['value']). '<br />';
//                       echo '--------------------<br />';                            
               }
           }
           //if formulas dependency order was not observed
           //$this->checkReplaceValues();
           
//           Helper::myPrint_r($this->clientProperties);
//           Helper::myPrint_r($this->itemProperties);
//           Helper::myPrint_r($this->rangeProperties);
//           Helper::myPrint_r($this->formulasValue);
//           Helper::myPrint_r($this->resultArray,true);

       }
       
       /**
       * Converts all array elements to upper case
       * array_map((array($this, 'myStrtoupper')), $matches[0]); 
       * @param mixed $n
       * @return string
       */
       protected function myStrtoupper($n)
       {
           return mb_strtoupper($n, 'utf-8');    
       }
       
       /**
       * Checks for errors in replaceValues()
       * Is used to remove all error when formulas weight (sorting order) is violated
       * It means, that the value for the placeholder used in a current formula doesn't exist,
       * because it will be calculated in the next or further formulas.
       * Normally all placeholder should be used in formula values corresponding to the order they are being calculated
       */
//       protected function checkReplaceValues()
//       {
           //TODO::rewrite this function. It should not run calculation once again/
           //First we have to replace all the values/
           //than run the calculation
//           if (count($this->errorReplacements) > 0)
//           {
//               foreach($this->formulasValue as $fvalue) 
//               {
                   //$fvalue['value']=mb_strtoupper($fvalue['value'], 'utf-8');
//                   preg_match_all('/\{([^}]+)\}/', $fvalue['value'], $matches);
//                   foreach($this->sizeList as $size) 
//                   {
//                       $this->replacement=array();
                       //$stag=mb_strtoupper($size.'_'.substr(substr($fvalue['tag'],0,-1),1), 'utf-8');
//                       $stag=$size.'_'.substr(substr($fvalue['tag'],0,-1),1);
//                       foreach($matches[1] as $match) 
//                       {
                           //$match=mb_strtoupper($match, 'utf-8');
//                           if(isset($this->itemProperties[$size . '_' . $match])) 
//                               $this->replacement[$size . '_' . $match]=$this->itemProperties[$size . '_' . $match];
//                           elseIf(isset($this->clientProperties[$match]))
//                               $this->replacement[$match]=$this->clientProperties[$match];
//                           elseIf(isset($this->resultArray[$size . '_' . $match]))
//                               $this->replacement[$size . '_' . $match]=$this->resultArray[$size . '_' . $match];
//                           else 
//                                $this->errorReplacements[$size . '_' . $match]=$size . '_' . $match;
//                       }

//                       $matches[0]=array_unique($matches[0]);
//                       echo '--------------------<br />';
//                       Helper::myPrint_r($matches[0]);
//                       Helper::myPrint_r($matches[1]);
//                       Helper::myPrint_r($this->replacement);
//                       echo 'fvalue' . $fvalue['value'] . '<br />';
//                       echo 'val: ' . $val = preg_replace($matches[0], $this->replacement, $fvalue['value']). '<br />';
//                       echo '--------------------<br />';
//                       $this->resultArray[$stag]=$this->calculate(preg_replace($matches[0], $this->replacement, $fvalue['value']));
//                   }
//               }
//           }  
//       }
       
       /**
       * Calculates formulas with values
       */
       protected function calculate($value)
       {   
//           $value=trim($value);
//           $value=preg_replace('/[\{\}]/', '', $value);    
//           if($value=='(((14.225*100)/0)*(100.00-100.00))/100+100.00') {
//                echo 'id: ' . $this->itemId;
//                echo '<br />';
//                echo 'type: ' . $this->itemTypeId;
//                echo '<br />';
//                echo 'formulasValue';
//                Helper::myPrint_r($this->formulasValue);
//                echo 'resultArray';
//                Helper::myPrint_r($this->resultArray);
//                die;
//           }
           
           $value=trim($value);
           $value=preg_replace('/[\{\}]/', '', $value);
           //return $value;
           //return null;
           //$result = eval( "return $value;" );
           //echo 'value: ' . $value .'<br />';
           //echo 'result: ' . $result .'<br /><br />';
           //return $result;
           $eq = new eqEOS();
           return $eq->solveIF($value);
       }

       /**
       * Loads item properties: title and all property values into an array
       * @param mixed $item_id is 141 for testing purpose
       * NOTICE! For a new property to load it is important to retreive it in '->select('title,il,iwa,iww...
       */
       public function loadItemProperties()
       {
            $data = Yii::app()->db->createCommand()
                ->select('t1.title,t1.il,t1.iwa,t1.iww,t1.iwt,t1.ils,t1.iws,t1.iwp,t1.iwss,t1.iwcb,t1.bw,t1.vpr,t1.rpli,t1.iwar,t1.iwwr,t2.stretch')
                ->from('itemsize as t1')
                ->leftJoin('item as t2','t2.id=t1.item_id')
                ->where('t1.item_id=:item_id', array(':item_id'=>$this->itemId))
                ->queryAll();
            
            foreach($data as $itemSize)
            {
                foreach($itemSize as $key=>$value) 
                {
                    if($key!='title') {
                        $this->itemProperties[$itemSize['title'].'_'.$this->itemS[$key]]=$value;
                        $this->sizeList[$itemSize['title']]=$itemSize['title'];
                    }    
                }
            }
            //Helper::myPrint_r($this->itemProperties);
       }
       
       /**
       * Loads client properties: title and all property values into an array
       * @param mixed $client_id is 8 for testing purpose
       * NOTICE! For a new property to load it is important to retreive it in ' ->select('service_title,value,vst,...
       */
       public function loadClientProperties()
       {
//            $data = Yii::app()->db->createCommand()
//                ->select('service_title,value,vst,vk,vzu,dts,dr,client_id')
//                ->from('client_size')
//                ->leftJoin('clientsize','clientsize.id=client_size.size_id')
//                ->where('client_size.client_id=:client_id AND client_size.is_locked=0', array(':client_id'=>$this->clientId))
//                ->queryAll();
//                
            $query = 'SELECT t2.service_title,t1.value,t1.vst,t1.vk,t1.vzu,t1.dts,t1.dr 
                    FROM client_size AS t1 
                    LEFT JOIN clientsize AS t2 
                    ON t1.size_id=t2.id 
                    WHERE t1.client_id=:client_id AND t1.is_locked=0;';

            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":client_id", $this->clientId, PDO::PARAM_STR);
            $data = $command->queryAll();                
                    
            
            foreach($data as $clientSize)
            {
                foreach($clientSize as $key=>$value) 
                {
                    if($key!='service_title' && $value!=0) {
                        if($key=='value')
                            $this->clientProperties[$clientSize['service_title']]=$value;
                        else    
                            $this->clientProperties[$this->clientS[$key]]=$value;
                    }
                }
            }
            //Helper::myPrint_r($this->clientProperties);
       }
       
       /**
       * Loads range properties for a given item_type
       * @param mixed $item_type_id is 4 for testing purpose
       */
       public function loadRangeProperties()
       {
            if (!file_exists(Yii::app()->runtimePath.'/formulaRangeList_'.$this->itemTypeId))
                throw new CHttpException(404,'Range file not found!');

            $data = unserialize(file_get_contents(Yii::app()->runtimePath.'/formulaRangeList_'.$this->itemTypeId));
            
            foreach($data as $key=>$range)
            {   
                $items=array();
                foreach($range as $key=>$value) 
                {
                    if($key!='title' && $key!='key' && $key!='type_id') {
                        if(!empty($value) || $value=='0')
                            $items[$range['title'].'_'.$key]=$value;
                    }
                }
                if(!empty($items))
                    $this->rangeProperties[$range['title']]=$items;
            }
       }
       
       /**
       * Loads formulas value for a given item type
       * @param mixed $item_type_id is 92 for testing purpose
       */
       public function loadFormulasValue()
       {
            $data = Yii::app()->db->createCommand()
                ->select('t1.id, t1.type_id, t1.title,t1.value,t1.tag,t1.fvalue,t1.type,t2.range,t3.user_title')
                ->from('formula as t1')
                ->leftJoin('resformulatitle as t2','t2.id=t1.title')
                ->leftJoin('resformulatitle_translation as t3','t3.id=t1.title AND t3.language_id=:lang',array(':lang'=>Yii::app()->language))
                ->where('t1.type_id=:item_type_id AND t1.is_locked=0', array(':item_type_id'=>$this->itemTypeId))
                ->order('t1.weight ASC')
                ->queryAll();
                //SELECT DISTINCT t1.title, t2.range, t3.user_title FROM formula as t1 LEFT JOIN resformulatitle as t2 ON t2.id=t1.title LEFT JOIN resformulatitle_translation as t3 ON t3.id=t1.title AND t3.language_id='ru' WHERE t1.type_id=50;                
            
            //separate formulas by type
            foreach($data as $key=>$value)
            {
                if(!empty($value['value'])) {
                    if($value['type']==1)
                        $this->formulasValue[$key]=$value;
                }        
                    elseIf($value['type']==2)
                        $this->rangeFormulas[$key]=$value;
                        
                    if(isset($this->rangeList[$value['range']]))
                        $this->useRangeList[]=$this->rangeList[$value['range']];
                    
            }
            
//            Helper::myPrint_r($this->formulasValue,true);
       }
       
       /**
       * Preloads initial data
       */
       public function init()
       {
           if(!empty($this->itemId))
                $this->loadItemProperties();
           
           if(!empty($this->clientId))
            $this->loadClientProperties();

           $this->loadRangeProperties();
           $this->loadFormulasValue();
           
       }
       
       /**
       * Exposes protected data
       */
       public function exposeData($data=false) 
       {
           if($data) {
                echo 'ItemId: ' . $this->itemTypeId.'<br />'; 
                echo 'Item properties:';
                    Helper::myPrint_r($this->itemProperties);
                echo 'Client properties:';
                    Helper::myPrint_r($this->clientProperties);
                echo 'Range properties:';
                    Helper::myPrint_r($this->rangeProperties);
                echo 'Formula values:';
                    Helper::myPrint_r($this->formulasValue);
           }    
                
            echo 'ReplaceValue called:<br/>';
            $this->replaceValues();
                
       }

       /**
       * Evaluates results within range data
       *    from ResFormulaTitle model:
       *     public $rangeList=array(
       *        '1'=>'CТ',
       *        '2'=>'CГ',
       *        '3'=>'CБ',
       *        '4'=>'ОП',
       *        '5'=>'ШГ',
       *        '6'=>'РП',        
       *     );
       *    Todo: cyrillic letters are dependent on binary code so it may be a problem when compared. This should be changed!
       *    That is СГ from rangeProperties array may be different from СГ in rangeList though they seem equal!
       */
       protected function analyzeRange()
       {
           $allrec=array();
           $rf_count=$this->finalResult['count']=count($this->rangeFormulas);;

           /**
           * The quantity of range short titles depends on the quantity of range formulas for a given item type.
           * The idea is valid given that we assume the range short titles in the following way: 'СГ',СТ',СБ',ОП',ШГ',РП'
           * In any other case there will be an error.
           * TODO: make range short titles quantity automatically determined. They should depend on the number of obligatory size types
           * for every item type.
           */
           
           foreach($this->rangeProperties as $key=>$properties)
           {
                //echo $key . '<br />';
                foreach($this->rangeFormulas as $rangef)
                {
                    if($this->rangeList[$rangef['range']] == $key) 
                    {                        
                        $verytightplus=$verytight=$recomended=$baggy=$baggypluss=array();
                        foreach($this->sizeList as $size) 
                        {
                            //$sized=$this->myStrtoupper($size .'_'. preg_replace('/[\{\}]/', '', $rangef['fvalue']));
                            $sized=$size .'_'. preg_replace('/[\{\}]/', '', $rangef['fvalue']);
                            //if(isset($this->resultArray[$this->myStrtoupper($sized)])) 
                            if(isset($this->resultArray[$sized])) 
                            {
                                switch ($this->between($this->rangeProperties[$key], $this->resultArray[$sized])) {
                                    case Evaluate::VERY_TIGHT_PLUS:
                                        $verytightplus[$size]=$this->resultArray[$sized];
                                        //echo 'SIZE: ' . $size . '  VERY_TIGHT_PLUS <br />' ;
                                        break;
                                    case Evaluate::VERY_TIGHT:
                                        $verytight[$size]=$this->resultArray[$sized];
                                        //echo 'SIZE: ' . $size . '  VERY_TIGHT <br />';
                                        break;
                                    case Evaluate::RECOMENDED:
                                        $recomended[$size]=$this->resultArray[$sized];
                                        if(in_array($key,$this->useRangeList))
                                            $this->recSize[]=$size;
                                        //echo 'SIZE: ' . $size . '  RECOMENDED <br />';    
                                        break;                                                                        
                                    case Evaluate::BAGGY:
                                        $baggy[$size]=$this->resultArray[$sized];
                                        //echo 'SIZE: ' . $size . '  BAGGY <br />';
                                        break;
                                    case Evaluate::BAGGY_PLUS:
                                        $baggypluss[$size]=$this->resultArray[$sized];
                                        //echo 'SIZE: ' . $size . '  BAGGY_PLUS <br />';
                                        break;
                                }                                
                                    
                            }
//                            echo 'Range-f: ' . $rangef['fvalue'] . ' Type: ' .$key .' Value: ' .$this->resultArray[$sized].' For SIZE: '. $size. ': ' . $this->between($this->rangeProperties[$key], $this->resultArray[$sized]).'<br />---------<br />';
                         }
                         
//                         echo '$verytightplus:';
//                         Helper::myPrint_r($verytightplus);
//                         
//                         echo '$verytigh:';
//                         Helper::myPrint_r($verytight);
//                         
//                         echo '$recomended:';
//                         Helper::myPrint_r($recomended);                         
//                         
//                         echo '$baggy:';
//                         Helper::myPrint_r($baggy);                           
//                         
//                         echo '$baggypluss:';
//                         Helper::myPrint_r($baggypluss);                          
                    }
                }

                $propType['rangeId']=array_search($key, $this->rangeList);
                $propType['rangeProperties']=$this->rangeProperties[$key];
                $propType['rangePropertiesSum']=$this->calculateRangeSum($key);
                
                //unset all array values if exists
                if(isset($propType['data'][Evaluate::VERY_TIGHT_PLUS]))
                    unset($propType['data'][Evaluate::VERY_TIGHT_PLUS]);
                    
                if(isset($propType['data'][Evaluate::VERY_TIGHT]))
                    unset($propType['data'][Evaluate::VERY_TIGHT]);

                if(isset($propType['data'][Evaluate::RECOMENDED]))
                    unset($propType['data'][Evaluate::RECOMENDED]);
                    
                if(isset($propType['data'][Evaluate::BAGGY]))
                    unset($propType['data'][Evaluate::BAGGY]);
                    
                if(isset($propType['data'][Evaluate::BAGGY_PLUS]))
                    unset($propType['data'][Evaluate::BAGGY_PLUS]);
                    
                if(isset($verytightplus) && !empty($verytightplus))
                    $propType['data'][Evaluate::VERY_TIGHT_PLUS]=array_unique($verytightplus);
                if(isset($verytight) && !empty($verytight))
                    $propType['data'][Evaluate::VERY_TIGHT]=array_unique($verytight);
                if(isset($recomended) && !empty($recomended)){
                    $recomended=array_unique($recomended);
                    arsort($recomended);//sort from largest to smallest. It is needed to determin which size is tighter or looser.
                    $propType['data'][Evaluate::RECOMENDED]=$recomended;
                }
                if(isset($baggy) && !empty($baggy))
                    $propType['data'][Evaluate::BAGGY]=array_unique($baggy);
                if(isset($baggypluss) && !empty($baggypluss))
                    $propType['data'][Evaluate::BAGGY_PLUS]=array_unique($baggypluss);
                
                $resData[$key]=$propType;
//                Helper::myPrint_r($resData);
            }

            $this->finalResult['evaluation']=$resData;
            //Helper::myPrint_r($this->finalResult,true);
            $this->preFinalResult();
            $this->setStatus();
//            Helper::myPrint_r($this->finalResult,true);
            return $this->finalResult;
       }
       
       protected function preFinalResult()
       {
           /**
           * Finds fully and semi fitted size and adds them to the korresponding arrays
           */
           if(!empty($this->recSize) && is_array($this->recSize)) { 
            $arr=array_count_values($this->recSize); 
            
               foreach($arr as $key=>$value)
               {
    //                $very_tught_plus=(isset($result['data'][Evaluate::VERY_TIGHT_PLUS]))
    //                    ? array_key_exists($key, $result['data'][Evaluate::VERY_TIGHT_PLUS])
    //                    : false;
    //                    
    //                $baggy_plus=(isset($result['data'][Evaluate::BAGGY_PLUS]))
    //                    ? array_key_exists($key, $result['data'][Evaluate::BAGGY_PLUS])
    //                    : false;                 
                   
                    $rangeListCount=count($this->useRangeList);
                    $lesBy=$rangeListCount-$value;
                    if($rangeListCount==$value)
                        $this->fullyFittedSizeList[$key]=Evaluate::RECOMENDED;
                    elseIf($lesBy==$this->entryNeededNotLessThan){
                        $this->semiFittedSizeList[$key]=Evaluate::SEMI_RECOMENDED;
                    }    
                    else
                        $this->notFittedSizeList[$key]=Evaluate::NOT_FITTED;    
               }
           }
           
//                if(!empty($this->fullyFittedSizeList)) {
//                }           
           
            /**
            * Checks if there is a semi or fully recomended size within the finalResult[range]['recomended'] array for each range
            * and removes them from 'recomended' and puts into another key 'semirecomeded';
            */
            foreach($this->finalResult['evaluation'] as $rkey=>$result)
            {
                if(!empty($this->semiFittedSizeList)) {
                    foreach($this->semiFittedSizeList as $key=>$fsize)
                    {
                        if(isset($result['data'][Evaluate::RECOMENDED]) && is_array($result['data'][Evaluate::RECOMENDED])){
                            if(array_key_exists($key, $result['data'][Evaluate::RECOMENDED])) {
                                $this->finalResult['evaluation'][$rkey]['data'][Evaluate::SEMI_RECOMENDED][$key]=$this->finalResult['evaluation'][$rkey]['data'][Evaluate::RECOMENDED][$key];
                                unset($this->finalResult['evaluation'][$rkey]['data'][Evaluate::RECOMENDED][$key]);
                            }
                        }    
                    }
                }                
                
                if(!empty($this->notFittedSizeList))
                {
                    /**
                    * Removed from recomended every size, that is in recomanded range only on one range formula
                    * amongst 3 or more. That is if the difference between the quantity of range formulas and
                    * the 'recomended' entries for a given size is more than set in $entryNeededNotLessThan=1, ot is removed
                    * from 'recomended' and marked as 'not fitted'
                    *  
                    */
                    foreach($this->notFittedSizeList as $key=>$fsize)
                    {
                        if(isset($result['data'][Evaluate::RECOMENDED]) && is_array($result['data'][Evaluate::RECOMENDED])){
                            if(array_key_exists($key, $result['data'][Evaluate::RECOMENDED])) {
                                $this->finalResult['evaluation'][$rkey]['data'][Evaluate::NOT_FITTED][$key]=$this->finalResult['evaluation'][$rkey]['data'][Evaluate::RECOMENDED][$key];
                                unset($this->finalResult['evaluation'][$rkey]['data'][Evaluate::RECOMENDED][$key]);
                            }
                        }    
                    }                    
                }
            }
       }

       /**
       * Set status to true if there is at least one fully or semi fitting size. False if there is no fitting size at all.
       */       
       protected function setStatus()
       {
            $countF=count($this->fullyFittedSizeList);
            $countS=count($this->semiFittedSizeList);
            
            if(is_array($this->fullyFittedSizeList)) {
                ksort($this->fullyFittedSizeList);
            
                $middleElem = ceil(count($this->fullyFittedSizeList)/2);
                $keys = array_keys($this->fullyFittedSizeList);      

                if(($s = sizeof($this->fullyFittedSizeList)) % 2 == 0) {//even
                        $this->idealSizeTight=$keys[$middleElem-1];
                        $this->idealSizeBaggy=$keys[$middleElem];
                        $this->sizeFitting=$this->idealSizeTight . ', ' . $this->idealSizeBaggy; 
                        $this->even=true;
                } else {//odd
                    if($countF==1) {
                        $this->idealSize=key($this->fullyFittedSizeList);                
                        $this->sizeFitting=$this->idealSize;
                    } else {
                        $this->idealSizeTight=$keys[$middleElem-2];
                        $this->idealSize=$keys[$middleElem-1];
                        $this->idealSizeBaggy=$keys[$middleElem];                   
                        $this->sizeFitting=$this->idealSizeTight . ', ' . $this->idealSize . ', ' .$this->idealSizeBaggy;
                        $this->even=false;
                    }
                } 
            }
           
           ($countF > 0) 
                ? $this->finalResult['status']=array(
                    'result'=>1,
                    'fitF'=>$countF,
                    'fitS'=>$countS,
                    'idealSizeTight'=>$this->idealSizeTight,
                    'idealSize'=>$this->idealSize,
                    'idealSizeBaggy'=>$this->idealSizeBaggy,
                    'sizeFitting'=>$this->sizeFitting,
                    'even'=>$this->even,
                )
                : $this->finalResult['status']=array(
                    'result'=>0,
                    'fitF'=>$countF,
                    'fitS'=>$countS,
                    'idealSizeTight'=>$this->idealSizeTight,
                    'idealSize'=>$this->idealSize,
                    'idealSizeBaggy'=>$this->idealSizeBaggy,
                    'sizeFitting'=>$this->sizeFitting,
                    'even'=>$this->even,
                    );
       }
       
       protected function getStatus()
       {
           return (isset($this->preFinalResult['status']['result'])) ? $this->preFinalResult['status']['result'] : 'undefined';
       }

       /**
       * Returns a class name depending on the range in between which the given value is suitable.
       * The script functions given than there are only four range values. If there will be more range values (like min,minr,maxr,max)
       * some modification will be needed.
       * 
       * @param mixed $prop contains range values
       * @param mixed $c_value contains value to be processed
       * @return mixed
       */
       protected function between($prop, $c_value)
       {
           $min=current($prop);
           $minr=next($prop);
           $maxr=next($prop);
           $max=end($prop);
           
           if($c_value <  $min)
                return Evaluate::BAGGY_PLUS;
           elseIf($c_value >= $min && $c_value < $minr)
               return Evaluate::BAGGY;
           elseIf($c_value >= $minr && $c_value <= $maxr)
                return Evaluate::RECOMENDED;
           elseIf($c_value > $maxr && $c_value <= $max)
                return Evaluate::VERY_TIGHT;
           elseIf($c_value > $max)
                return Evaluate::VERY_TIGHT_PLUS;
           else
                return Evaluate::UNDEFINED;
       }

       /**
       * Calculates the sum for two range values
       * @param mixed $key
       */
       protected function calculateRangeSum($key)
       {    
            $this->rangePropertiesSum=array();
            $this->rangePropertiesSum[Evaluate::BAGGY]=$this->calculateTwoRanges($this->rangeProperties[$key][$key.'_min'],$this->rangeProperties[$key][$key.'_minr']);
            $this->rangePropertiesSum[Evaluate::RECOMENDED]=$this->calculateTwoRanges($this->rangeProperties[$key][$key.'_minr'],$this->rangeProperties[$key][$key.'_maxr']);
            $this->rangePropertiesSum[Evaluate::VERY_TIGHT]=$this->calculateTwoRanges($this->rangeProperties[$key][$key.'_maxr'],$this->rangeProperties[$key][$key.'_max']);
            //Helper::myPrint_r($this->rangePropertiesSum,true);
            return $this->rangePropertiesSum;
       }
       
        /**
        * Варианты:
        * значения всегда поступают по направлению слева на право. Т.е. отрицательное или меньшее число всегда будет слева
        * 1) min отрицательное max - отрицательное: переводим оба в положительное и от mim отнимаем max
        * 2) min отрицательное max - положительное (в т.ч. 0): переводим min в положительное и плюсуем min и max
        * 3) min и max положительные - отнимаем от max min
        */
       protected function calculateTwoRanges($min,$max)
       {
           if($min < 0 && $max < 0) 
                return array('sum'=>abs($max)-abs($min),'difference'=>0,'min'=>$min);
            elseIf($min < 0 && $max >= 0) 
                /**
                * Calculates the difference between zero and negative range value.
                * Example: range -18 -> 55. In this case the difference is 18
                */
                return array('sum'=>abs($min)+$max,'difference'=>abs($min),'min'=>$min);
            elseIf($min == 0 && $max > 0) 
                return array('sum'=>$max-$min,'difference'=>abs($min),'min'=>$min);
            elseIf($min > 0 && $max > 0) 
                return array('sum'=>$max-$min,'difference'=>abs($min),'min'=>$min);                
            else 
                return array('sum'=>'undefined','difference'=>0,'min'=>'undefined');
       }
       
       public function evaluateSize()
       {
           return $this->analyzeRange();
       }
       
       public function prepareMultipleEvaluation($itemID)
       {
           $this->itemProperties=array();
           $this->finalResult=array();
           $this->preFinalResult=array();
           $this->fullyFittedSizeList=array();
           $this->semiFittedSizeList=array();
           $this->notFittedSizeList=array();
           $this->idealSize=0;
           $this->idealSizeTight=0;
           $this->idealSizeBaggy=0;           
           
           
           $this->itemId=$itemID;
           $this->loadItemProperties();   
           $this->replaceValues();
           return $this->analyzeRange();
       }       
  }
?>
