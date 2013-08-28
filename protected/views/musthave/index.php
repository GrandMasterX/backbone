    <?php
        $app=Yii::app();
        $baseUrl=$app->baseUrl;
        
        //$itemID=264,$itemTypeId=48, $clientId=6   
        $ev=new Evaluate(264,48,6);
        $ev->evaluateSize();
    ?>
                <form method="post" action="" id="item">
                    <input type="hidden" name="id" value="297">
                    <div class="foto_item">
                    <?php if ($model->mainItemImage):?>   
                        <img id="imagePreview" src="<?php echo Yii::app()->baseUrl . DIRECTORY_SEPARATOR . Item::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR . 
                            $model->id . DIRECTORY_SEPARATOR . $model->mainItemImage['1']->name ?>" alt="" width="320" height="480">
                    <?php else: ?>
                        <img id="imagePreview" src="<?php echo Yii::app()->baseUrl?>/static/img/musthave/noimage.png" alt="" width="320" height="480">                       
                    <?php endif ?>   
                    </div>
                    <div class="item_descr">
                        <div>
                            <ul class="item_more_img def clearfix">
                                <?php if ($model->galleryImages):?>
                                    <?php foreach ($model->galleryImages as $imageItem): ?> 
                                        <li class="lipre"><img src="<?php echo Yii::app()->baseUrl . DIRECTORY_SEPARATOR . Item::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR . 
                                            $model->id . DIRECTORY_SEPARATOR . $imageItem->name ?>" width="40" height="40"></li>
                                    <?php endforeach; ?>
                            <?php endif; ?>     
                            </ul>
                        </div>
                        <div id="param">
                                                    <dl>
                                <dt style="width: 53px;">Код:</dt>
                                <dd><?php echo $model->code; ?></dd>
                            </dl>
                                                <dl>
                            <dt style="width: 53px;">Цвет:</dt>
                            <dd>
                                <input type="hidden" name="color" value="13">
                                <ul class="colors def clearfix">
                                    <li class="active" data-value="13"><span onclick="changePicture(13,297)" style="background-color:#<?php echo $model->colour; ?>;"><span></span></span></li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="size_s">
                            <input type="image" src="http://www.astrafit.com.ua/static/img/pink_button_ru.png" name="image" width="145" height="13" onclick="PopupWindowCenter('http://www.astrafit.com.ua/site/suitableItems?parent_id=4&mass=1', 'PopupWindowCenter',1250,620); return false;">
                            <?php if (Yii::app()->user->isGuest): ?>
                            <input class="get-size-btn" type="image" src="http://www.astrafit.com.ua/static/img/pink_button_ru.png" name="image" width="145" height="13" onclick="PopupWindowCenter('http://www.astrafit.com.ua/site/suitableItems?parent_id=4', 'PopupWindowCenter',1250,620); return false;">
                            <?php if (YII_DEBUG): ?>
                                <input class="get-size-btn" type="image" src="http://www.astrafit.com.ua/static/img/widget_ru.png" name="image" width="125" height="50" onclick="PopupWindowCenter('http://www.astrafit.com.ua/register/index?code=<?php echo $model->code?>', 'PopupWindowCenter',1250,620); return false;">
                                <input class="" type="image" src="http://www.astrafit.com.ua/static/img/pink_button_ru.png" name="image" width="145" height="13" onclick="PopupWindowCenter('http://www.astrafit.com.ua/site/suitableItems?parent_id=4', 'PopupWindowCenter',1250,620); return false;">
                            <?php else: ?>
                                <input class="get-size-btn" type="image" src="<?php echo $baseUrl?>/static/img/widget_<?php echo Yii::app()->language; ?>.png" name="image" width="125" height="50" onclick="PopupWindowCenter('http://www.test.astrafit.com.ua/register/index?code=<?php echo $model->code?>', 'PopupWindowCenter',1250,620); return false;">
                            <?php endIf; ?>    
                        <?php else: ?>
                            <?php if (YII_DEBUG): ?>
                                <input class="get-size-btn" type="image" src="<?php echo $baseUrl?>/static/img/widget_<?php echo Yii::app()->language; ?>.png" name="image" width="125" height="50" onclick="PopupWindowCenter('http://localhost/astrafit/index-dev.php/site/result?code=<?php echo $model->code?>', 'PopupWindowCenter',1250,620); return false;">
                            <?php else: ?>
                                <input class="get-size-btn" type="image" src="<?php echo $baseUrl?>/static/img/widget_<?php echo Yii::app()->language; ?>.png" name="image" width="125" height="50" onclick="PopupWindowCenter('http://www.test.astrafit.com.ua/site/result?code=<?php echo $model->code?>', 'PopupWindowCenter',1250,620); return false;">
                            <?php endIf; ?>
                        <?php endIf; ?>
                            <dt style="width: 53px;">Размер:</dt>
                            <dd>
                                <?php echo CHtml::dropDownList('size','size_select', 
                                    CHtml::listData($model->sizeList,'id', 'title')
                                    );
                                ?>                                
                            </dd>
                        </dl>
                        <dl>
                            <dt style="width: 53px;">Состав:</dt>
                            <dd>коттон и эластан</dd>
                        </dl>
                        </div>
                            <div class="price"><?php echo $model->price; ?> грн.</div>
                        <div class="buy_wrap">
                            <a href="#" class="button buybutton" onclick="BuyItem();"><span>В корзину</span></a>
                        </div>
                        <ul class="links def">
                            <li><a href="#">Таблица размеров</a></li>
                            <li><a href="#">Оплата и доставка</a></li>
                        </ul>
                    </div><!--item_descr-->
                    <div class="clear"></div>
                    <div class="section">
                    <div class="section_wrap">
                     <div class="box_wrap">
                     </div>
                     </div>
                    </div>                    
                    <div class="next_prev_item clearfix">
                        <div class="prev"><a href="#"><i></i><span>0287 Платье желтое, желтый, вырез лодочка, коттон, длинный рукав</span></a></div>
                        <div class="next"><a href="#"><span>0289 Платье голубое, вырез лодочка, голубой, карманы</span><i></i></a></div>
                    </div>

                    <div class="other_items">
                        <div class="controls"><!--
                            --><span class="active">Это можно одеть с</span><!--
                            --><span>Недавно просмотренные</span><!--
                        --></div>
                        <div class="wrap">
                            <ul class="box def clearfix">
                                                                                            </ul>
                            <ul class="box def clearfix">
                                <li><a href="http://musthave.ua/product/302/"><img src="" alt=""></a></li><li><a href="http://musthave.ua/product/299/"><img src="" alt=""></a></li>                            </ul>
                        </div>
                    </div>
                </form>