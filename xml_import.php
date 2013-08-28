<?php
    $mysqli = new mysqli("localhost", "musthave_db", "osMlJSaX", "musthave_db");

    if (mysqli_connect_errno()) {
        printf("Ошибка соединения: %s\n", mysqli_connect_error());
        exit();
    }
    
    /**
    * '1'=>'37' where '1' is musthave category id and '37' is itemType id at astraFit
    */
    $types=array(
        '1'=>'37',//Плащи
        '7'=>'3', //Брюки
        '6'=>'10',//Юбки
        '4'=>'40',//Рубашки
        '5'=>'4',//Платья
        '8'=>'41',//Жакеты
        '9'=>'42',//Майки
        '10'=>'8',//Шорты
        '11'=>'43',//Пуловеры
    ); 

    //SELECT * FROM eshop_products RIGHT JOIN eshop_products_images ON eshop_products.category_id=eshop_products_images.product_id ORDER BY eshop_products.category_id    
    $result = mysqli_query($mysqli, "SELECT * FROM `eshop_products` ORDER BY `category_id`");

    $xml = new DomDocument('1.0', 'utf-8'); 
    //create root of xml-document
    $items = $xml->appendChild($xml->createElement('items'));      
    $items->setAttribute("last_modified", mktime());
    $i=1;
    while($row = mysqli_fetch_assoc($result) ){ 
        $item = $items->appendChild($xml->createElement('item'));

        $param = $item->appendChild($xml->createElement('code'));
        $param->appendChild($xml->createTextNode($row['code']));
        
        $param = $item->appendChild($xml->createElement('type_id'));
        $param->appendChild($xml->createTextNode($types[$row['category_id']]));                       
        
        $param = $item->appendChild($xml->createElement('title'));
        $param->appendChild($xml->createTextNode($row['name']));        
        
        $param = $item->appendChild($xml->createElement('desc'));
        $param->appendChild($xml->createTextNode($row['structure']));                

        $param = $item->appendChild($xml->createElement('price'));
        $param->appendChild($xml->createTextNode($row['price']));
        
        $param = $item->appendChild($xml->createElement('text'));
        $param->appendChild($xml->createTextNode($row['text']));                                  
        
        $id=$row['id'];
        $itemColours = mysqli_query($mysqli, "SELECT * FROM eshop_colors m INNER JOIN products2colors pc ON m.id=pc.color_id WHERE pc.product_id=$id");
        $colours = $item->appendChild($xml->createElement('colours'));
        while($colourRow = mysqli_fetch_assoc($itemColours) ){
            $colour = $colours->appendChild($xml->createElement('colour'));
            $colour->appendChild($xml->createTextNode($colourRow['code']));             
        }          
        
        $images = $item->appendChild($xml->createElement('images'));
        $image = $images->appendChild($xml->createElement('image'));
        $image->appendChild($xml->createTextNode($row['image']));
        $image->setAttribute("main", 1);
        
        $itemImages = mysqli_query($mysqli, "SELECT * FROM eshop_products_images WHERE eshop_products_images.product_id=$id");
        while($imageRow = mysqli_fetch_assoc($itemImages) ){
            $image = $images->appendChild($xml->createElement('image'));
            $image->appendChild($xml->createTextNode($imageRow['image']));             
        }
    $i++;
    }
    
    $xml->formatOutput = true;
    $xml->save('musthave.xml');
    mysqli_free_result($result);  
    
    $mysqli->close();
    echo "Успешно обработано $i записей";
?>
