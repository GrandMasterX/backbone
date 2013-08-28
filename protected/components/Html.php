<?php
  class Html extends CHtml 
  {
    
    public static function createDir($dirName, $permissions = '0777')
    {
        if (!file_exists($dirName) || !is_dir($dirName))
        {
            mkdir($dirName);
            //chmod($dirName, $permissions);
        }
    }
    
    public static function removeDir($dirName)
    {
        if (file_exists($dirName) && is_dir($dirName))
        {
            rmdir($dirName);
        }
    }
    
    public static function listTreeData($models,$valueField,$textField,$groupField='')
    {
        $listData=array();
        foreach($models as $model)
        {
            if($model->level==2)
            {
                $value=self::value($model,$valueField);
                $text=self::treeValue($model,$textField,'',"-- ");                
            }
            elseif($model->level==3)
            {
                $value=self::value($model,$valueField);
                $text=self::treeValue($model,$textField,'',"---- ");
            } 
            else
            {
                $value=self::value($model,$valueField);
                $text=self::value($model,$textField);                
            }

            $listData[$value]=$text;
        }

        return $listData;
    }
    
    public static function makeTreeDataFromArray($array,$valueField,$textField,$groupField='')
    {
        $listData=array();
        foreach($array as $arr)
        {
            $value=self::value($arr,$valueField);
            $text=self::value($arr,$textField);
            $listData[$value]=$text;
        }
        return $listData;
    }
    
    public static function treeValue($model,$attribute,$defaultValue=null,$tag1=null)
    {
        foreach(explode('.',$attribute) as $name)
        {
            if(is_object($model))
                $model=$tag1 . $model->$name;
            else if(is_array($model) && isset($model[$name]))
                $model=$tag1 . $model[$name];
            else
                return $defaultValue;
        }
        return $model;
    }
  }
?>
