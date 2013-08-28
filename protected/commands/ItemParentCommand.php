<?php
class ItemParentCommand extends CConsoleCommand
{
	public function run()
	{
        $items=Item::model()->visible()->findAll();

        if ($items===null)
            throw new CHttpException(404);           
        
        $i=1;
        $item_count=count($items);
        echo "Total items ammount: " . $item_count."\n";
        foreach($items as $item)
        {
            $item->scenario='parentID';
            if($item->save(false))
                echo 'Item # '.$i.' Saved! - ' .($item_count-$i)." left.\n";
            else
                echo "Error!\n";
            
            $i++;
        } 

	}
}