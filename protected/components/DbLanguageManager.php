<?php
class DbLanguageManager extends CApplicationComponent
{
    //TODO: дописать проверку Yii::app()->request->preferredLanguage
    public function init()
    {
        parent::init();

        if(isset($_GET['language']))
            Yii::app()->language=$_GET['language'];
        elseif(isset(Yii::app()->user->language))
            Yii::app()->language=Yii::app()->user->language;
        else
            Yii::app()->language=Yii::app()->sourceLanguage;
    }

    public function getLanguages($visible=true)
    {
        static $items=array();

        if(!isset($items[$visible]))
        {
            if($visible)
                $models=Language::model()->visible()->weighted()->findAll();
            else
                $models=Language::model()->weighted()->findAll();

            foreach($models as $model)
                $items[$visible][$model->code]=$model->title;
        }
        return $items[$visible];
    }
}