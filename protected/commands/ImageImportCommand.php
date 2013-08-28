<?php
class ImageImportCommand extends CConsoleCommand
{
	public function run($args)
	{
		$baseDir=pathinfo(Yii::app()->request->scriptFile);
        $baseDir=substr($baseDir['dirname'],0,-9);

        $models=ItemImageImport::model()->findAll();
        $i=1;
        foreach($models as $model)
        {
            //touch(Yii::app()->runtimePath.'/imageImport');
            $imageModel=new ItemImage();
            $imageModel->item_id=$model->item_id;
            $imageModel->main=$model->main;
            $imageModel->name=basename($model->name);
            $imageModel->ext=(string)substr($model->path,strrpos($model->path,'.')+1);

            $dirName=$baseDir . Item::GALLERY_IMAGES_DIR."/{$model->item_id}";
            if (!file_exists($dirName) || !is_dir($dirName))
            {
                mkdir($dirName);
                chmod($dirName, 0777);
            }

            $image = file_get_contents($model->path_with_url);
            $filename=$dirName."/{$imageModel->name}";
            if(file_put_contents($dirName."/{$imageModel->name}", $image))

            //thumbnail
            $th_filename=$imageModel->getPathForThumb(ItemImage::THUMB_SMALL);
            if (file_exists($filename)) {
                $image=Yii::app()->image->open($filename);
                echo "Image loaded! \n";
                $thumbnail=$image->thumbnail(new Imagine\Image\Box(215,300));
                echo "Image thumbnail created! \n";
                $thumbnail->save($th_filename,array('quality' => 100));
                unset($image);
                unset($thumbnail);
                echo "Image thumbnail SAVED! \n";
                $imageModel->thumbnail=ItemImage::THUMB_SMALL . $model->name;
                //$imageModel->save(false);
            } else {
                echo "File: {$filename} does not exist!\n\n";
            }

            $imageModel->save(false);

            $model->delete();

            echo $i++;
        }
	}
}