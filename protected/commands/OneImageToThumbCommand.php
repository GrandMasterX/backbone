<?php
class OneImageToThumbCommand extends CConsoleCommand
{
    public function run($args)
    {
        
        $criteria=new CDbCriteria();
        $criteria->addInCondition('item_id', array('288', '290', '287'), 'OR');
        $models=ItemImage::model()->findAll($criteria);
        echo count($models) . "found\n";
        $i=1;
        foreach($models as $model)
        {
            if(is_null($model->thumbnail)) {
                $filename=$model->getFile();
                $th_filename=$model->getPathForThumb(ItemImage::THUMB_SMALL);
                
                //every time a new thumb is created, the old one should be deleted
                if(file_exists($th_filename)) {
                    unlink($th_filename);
                }
                
                echo "------- Records processed: {$i} -------\n";
                echo "Item id: {$model->item_id} image name: {$model->name} \n";
                echo "load image: {$filename} \n";  
                echo "image thumb name: {$th_filename} \n\n";
                if (file_exists($filename)) {
                    $image=Yii::app()->image->open($filename);
                    echo "Image loaded! \n";
                    $thumbnail=$image->thumbnail(new Imagine\Image\Box(215,300));
                    echo "Image thumbnail created! \n";
                    $thumbnail->save($th_filename,array('quality' => 100));    
                    unset($image);
                    unset($thumbnail);
                    echo "Image thumbnail SAVED! \n";
                    $model->thumbnail=ItemImage::THUMB_SMALL . $model->name;
                    $model->save(false);
                } else {
                     echo "File: {$filename} does not exist!\n\n";  
                }
            }
            $i++;
        }        
    }
}