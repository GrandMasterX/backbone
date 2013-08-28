<?php
class SynchronizeCommand extends CConsoleCommand
{
    public function run($args)
	{
        $models=Item::model()->findAll('partner_id=:id',array(':id'=>$args[0]));

        if(empty($models))
            throw new CHttpException(404,'No items found in base (item) table for the given partner');
        else
            $this->Synchronize($models);
	}

    public function Synchronize($models)
    {
        foreach($models as $model)
        {
            $sourceItem=ItemSource::model()->findByAttributes(array('code'=>$model->code));
            if($sourceItem===null)
                echo "No source model found for base model: {$model->code}\n";
            else {
                if($model->comment != $sourceItem->comment) {
                    $itemSizeList=count($model);
                    $sourceItemSizeList=count($sourceItem);
                    echo "-------Base item -> source Item-------\n
                    id: {$model->id} -> {$sourceItem->id} \n
                          code: {$model->code} -> {$sourceItem->code}\n
                          type_id: {$model->type_id} -> {$sourceItem->type_id}\n
                          fabric_id: {$model->fabric_id} -> {$sourceItem->fabric_id}\n
                          colour: {$model->colour} -> {$sourceItem->colour}\n
                          stretch: {$model->stretch} -> {$sourceItem->stretch}\n
                          bretel: {$model->bretel} -> {$sourceItem->bretel}\n
                          price: {$model->price} -> {$sourceItem->price}\n
                          comment: {$model->comment} -> {$sourceItem->comment}\n
                          ------ Size ------ \n
                          sizeCount: {$itemSizeList} -> {$sourceItemSizeList}\n\n
                          ";
                }

//                if(count($model->sizeList) != count($sourceItem->sizeList))
//                echo "sizeCount for base model {$model->id} and  source model {$sourceItem->id} is different\n";
            }
        }
    }
}