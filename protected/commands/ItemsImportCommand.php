<?php
class ItemsImportCommand extends CConsoleCommand
{
	protected $partner_id;
    public function run($args)
	{
        touch(Yii::app()->runtimePath.'/import');
        $this->partner_id=$args[0];
        $model=User::model()->findByPk($args[0]);

        if ($model===null)
            throw new CHttpException(404);   

        $xml=simplexml_load_file($model->xml_url);
        if($xml)
        {
            $model->last_import_date=new CDbExpression('NOW()');
            $model->xml_import_file_date=$xml['last_modified'][0];
            $model->save();
            
            if($this->ImportItems($xml, $model))
                return true;
            else
                return false;
        }
	}

    public function ImportItems($xml, $partner)
    {
        $state=false;
        $errors=array();
        $i=1;
        foreach($xml->children() as $item)
        {
            $existingItem=Item::model()->findByAttributes(
                array('code'=>$item->code),'partner_id=:partner_id',array(':partner_id'=>$this->partner_id));

            if($existingItem === null)
            {
                echo "------------------------------- Item ($i) -----------------------------------\n";
                echo 'old id: ' .$item->oldid ."\n";
                $model=new Item('import');
                $model->code=$item->code;
                $model->old_id=$item->oldid;
                $model->partner_id=$partner->id;
                $model->type_id=$item->type_id;
                $model->brand=$item->brand;
                $model->price=$item->price;
                $model->price_rent=$item->price_rent;

                //colors for musthave
                if(isset($item->colours->colour))
                {
                    foreach($item->colours->colour as $colour)
                    {
                        if(empty($model->colour))
                            $model->colour=$colour;
                        else
                            $model->colour=$model->colour . '; ' . $colour;
                    }
                }
                //tag name to be used from now and in future
                if(isset($item->colorlist->color))
                {
                    foreach($item->colorlist->color as $colour)
                    {
                        if(empty($model->colour))
                            $model->colour=$colour;
                        else
                            $model->colour=$model->colour . '; ' . $colour;
                    }
                }

                if($model->save(false))
                    $state=true;
                else
                    $state=false;

                echo "Item with id: {$model->id} saved with state $state\n\n";

                echo "------------------------------- ItemSize -----------------------------------\n";

                if(isset($item->sizelist->size))
                {
                    foreach($item->sizelist->size as $size)
                    {
                        $itemSize=new ItemSize('sizeImport');
                        $itemSize->title=$size;
                        $itemSize->item_id=$model->id;
                        $itemSize->save(false);
                    }
                }


                echo "------------------------------- ItemTranslation -----------------------------------\n";

                $languages=Language::model()->visible()->weighted()->findAll();
                foreach($languages as $language)
                {
                    $itemTranslation=new ItemTranslation;
                    $itemTranslation->id=$model->id;
                    $itemTranslation->language_id=$language->code;
                    $itemTranslation->title=$item->title;
                    $itemTranslation->desc=$item->desc;
                    if($itemTranslation->save(false))
                        $state=true;
                    else
                        $state=false;

                    echo "itemTranslation with id: {$itemTranslation->id} saved with state $state for language:$language->code \n\n";
                }

                echo "------------------------------- Item Images -----------------------------------\n";
                //save images to be imported later
                foreach($item->images->image as $img)
                {
                    $import=new ItemImageImport();
                    $import->item_id=$model->id;
                    $import->name=basename($img);
                    //$import->path_with_url=$partner->www . $img;
                    $import->path_with_url=$img;
                    $import->main=($img['main']) ? $img['main'] : null;
                    if($import->save(false))
                        $state=true;
                    else
                        $state=false;

                   echo "itemImage with id: {$import->id} saved with state $state\n\n";
                }
                $i++;
//                if($i==5)
//                    die('end');
            }
            else
            {
                echo "Item with code; {$existingItem->code} already exists\n";
            }
        }
        return $state;
    }
}