<?php
class ClientNewPropCommand extends CConsoleCommand
{
	public function run()
	{
        $clients=User::model()->findAll();

        if ($clients===null)
            throw new CHttpException(404);           
        
        $i=1;
        $client_count=count($clients);
        echo "Total clients count: " . $client_count ."\n";
        foreach($clients as $client)
        {
            foreach($client->sizeList as $size)
            {
                if($size->size_id==7)
                {
                    $size->scenario='process';
                    if($size->save(false))
                        echo 'Size has been saved.\n';
                }

            }

            echo 'Users # '.$i.' Saved! - ' .($client_count-$i)." left.\n";
            $i++;
        } 

	}
}