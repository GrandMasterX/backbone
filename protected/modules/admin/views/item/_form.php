<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>($model->isNewRecord) ? 'create-item-form' : 'update-item-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal',
                'enctype' => 'multipart/form-data',
                ),
            )); ?>

	<fieldset>
		<legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>

        <div class="control-group">
            <?php echo $form->labelEx($model,'code', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin"> 
                <?php echo $form->textField($model,'code',array('size'=>10)); ?>
                <?php echo $form->error($model,'code'); ?>
            </div>           
        </div>        
        
        <div class="tab-holder-item">  
            <?php $this->widget('bootstrap.widgets.TbTabs', array(
                'type'=>'tabs',
                'tabs'=>$this->generateTranslationFieldsForTab($model,$form),
            )); ?>
        </div>  
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'partner_id', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin"> 
                <?php echo Chosen::activeDropDownList($model, 'partner_id', User::getPartnersList(), array('empty'=>Yii::t('company', 'Выберите из списка'))); ?> 
                <?php echo $form->error($model,'partner_id'); ?>
            </div>           
        </div>
                
        <div class="control-group">
            <?php echo $form->labelEx($model,'type_id', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin"> 
                <?php echo Chosen::activeDropDownList($model, 'type_id', ItemType::getListOfItemType(), array('empty'=>Yii::t('item', 'Выберите из списка'),'enable_split_word_search'=>true)); ?> 
                <?php echo $form->error($model,'type_id'); ?>
            </div>           
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'fabric_id', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo Chosen::activeDropDownList($model, 'fabric_id', Item::getFabricList(), array('id'=>'fabric_id','empty'=>Yii::t('company', 'Выберите из списка'))); ?>
                <?php echo $form->error($model,'fabric_id'); ?>
            </div>
        </div>

<!-------------------->
        <div class="add-param-holder" style="display:none">
            <div class="control-group">
                <?php echo $form->labelEx($model,'fabric_type_iwa', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo Chosen::activeDropDownList($model, 'fabric_type_iwa', Item::getFabricList(1), array('empty'=>Yii::t('company', 'Выберите из списка'))); ?>
                    <?php echo $form->error($model,'fabric_type_iwa'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'fabric_type_iwa_stretch', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo $form->textField($model,'fabric_type_iwa_stretch',array('size'=>10)); ?>
                    <?php echo $form->error($model,'fabric_type_iwa_stretch'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'fabric_type_iww', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo Chosen::activeDropDownList($model, 'fabric_type_iww', Item::getFabricList(1), array('empty'=>Yii::t('company', 'Выберите из списка'))); ?>
                    <?php echo $form->error($model,'fabric_type_iww'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'fabric_type_iww_stretch', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo $form->textField($model,'fabric_type_iww_stretch',array('size'=>10)); ?>
                    <?php echo $form->error($model,'fabric_type_iww_stretch'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'fabric_type_iwt', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo Chosen::activeDropDownList($model, 'fabric_type_iwt', Item::getFabricList(1), array('empty'=>Yii::t('company', 'Выберите из списка'))); ?>
                    <?php echo $form->error($model,'fabric_type_iwt'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'fabric_type_iwt_stretch', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo $form->textField($model,'fabric_type_iwt_stretch',array('size'=>10)); ?>
                    <?php echo $form->error($model,'fabric_type_iwt_stretch'); ?>
                </div>
            </div>
        </div>
<!-------------------->

        <div class="control-group">
            <?php echo $form->labelEx($model,'colour', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php $this->widget('ext.SMiniColors.SActiveColorPicker', array(
                    'model' => $model,
                    'attribute' => 'colour',
                    'hidden'=>false,
                    'options' => array(),
                    'htmlOptions' => array('size'=>50, 'readonly'=>'true'),
                ));?>  
                <?php echo $form->error($model,'colour'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'stretch', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($model,'stretch',array('size'=>10)); ?>
                <?php echo $form->error($model,'stretch'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'stretchp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($model,'stretchp',array('size'=>10)); ?>
                <?php echo $form->error($model,'stretchp'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'bretel', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->checkBox($model,'bretel'); ?>
                <?php echo $form->error($model,'bretel'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'price', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($model,'price',array('size'=>10)); ?>
                <?php echo $form->error($model,'price'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'ready', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php 
                    $atr=($model->mainItemImage) ? array('size'=>10) : array('size'=>10,'checked'=>'0','disabled'=>'disabled');
                ?>
                <?php echo $form->checkBox($model,'ready',$atr); ?>
                <?php echo $form->error($model,'ready'); ?>
                <?php if(!$model->mainItemImage):?>
                    <div class="well" style="width:600px!important; margin: 15px 0 5px 0">
                        <p class="text-error"><?php echo Yii::t('item','У данного изделия нет фото. 
                            Статус "Обработано" можно поставить только тем изделиям, у которых есть фото');?></p>
                    </div>
                <?php endIf; ?>
            </div>
        </div>                  
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'unavailable', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->checkBox($model,'unavailable'); ?>
                <?php echo $form->error($model,'unavailable'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'comment', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textArea($model,'comment'); ?>
                <?php echo $form->error($model,'comment'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'size_finished', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->checkBox($model,'size_finished'); ?>
                <?php echo $form->error($model,'size_finished'); ?>
            </div>
        </div>

   <?php if(!$model->isNewRecord): ?>
    <fieldset>
        <legend id="size_pos"><span class="left-margin"><?php echo Yii::t('formGeneral', 'Размеры')?></legend>        
        <div id="sizeTab">
            <?php $this->renderPartial('_itemSizeTabs', array('model'=>$model, 'form'=>$form)); ?>
        </div>
        <div class="control-group" style="margin-top:0px !important">
            <div class="controls item-l-margin">
              <?php
                    echo CHtml::ajaxSubmitButton(Yii::t('item', 'Добавить новый размер'), 
                        Yii::app()->controller->createUrl('createItemSize',array('id'=>$model->id, 'new'=>true)), 
                        array(
                            'type' => 'POST',
                            'data' =>'',
                            'success' => 'function(data){
                               $("div#sizeTab").html(data);
                            }',
                        ),
                        array(
                           'type' => 'submit',
                           'class'=>'btn btn-primary'
                        ));
              ?>
            </div>
        </div>        
    </fieldset>
    <?php endIf; ?>     
    <fieldset>
        <legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Основное фото')?></legend>                       
            <div class="control-group">  
                <?php echo $form->labelEx($model,'mainImage', array('class'=>'control-label item-w')); ?>  
                <div id="main-image-holder" class="controls item-l-margin">  
                    <div id="main-image-wrapper">
                        <?php $this->renderPartial('_photo', array('model'=>$model)); ?>
                    </div>            
                    <?php echo $form->error($model,'mainImage'); ?>
                    <div id="button_holder">
                        <?php echo $form->FileField($model,'mainImage'); ?>
                    </div>
                </div>
            </div>
    </fieldset>

    <fieldset>
    <legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Галерея')?></legend>                           
        <div class="control-group">  
            <?php echo $form->labelEx($model,'gallery', array('class'=>'control-label item-w')); ?>  
            <div class="controls item-l-margin">   
                <div id="main_gallery_holder" class="row">
                        <?php $this->renderPartial('_gallery', array('model'=>$model)); ?>  
                </div> 
            </div> 
        </div> 
        
        <div class="control-group">  
            <div class="controls item-l-margin">  
            <?php echo Sweeml::activeAsyncFileUpload($model, 'gallery',array(
                'content' => Yii::t('uploader', 'Выбрать фотографии'),
                'config' => array(
                    'runtimes' => 'html5, flash',
                    'auto' => true,
                    'ui' => true,
                    'maxFileSize' => '2048mb',
                    'multiSelection' => true,
                ),
                'events'=>array(
                    'beforeUpload' => 'js:function(up, file){ 
                    }',
                    'uploadComplete' => 'js:function(up, files){
                    }',
                )
            )); ?>
            <?php echo $form->error($model,'gallery'); ?> 
            </div>
        </div>        
        
    </fieldset>
        <div class="control-group">
            <div class="controls item-l-margin">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? Yii::t('item', 'Создать') : Yii::t('language', 'Обновить'), array('name'=>'onlySubmit', 'class'=>'btn btn-success')); ?>
                <?php 
                    if($model->isNewRecord)
                      echo CHtml::submitButton(Yii::t('language', 'Создать и добавить размеры'), array('name'=>'movoToSize','class'=>'btn btn-success')); 
                ?>
                <?php echo CHtml::link(Yii::t('item', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
        </div>

    </fieldset>

<?php $this->endWidget(); ?>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScript(__FILE__,"

    if($('#fabric_id').val()==4)
        $('.add-param-holder').show();

    $('#fabric_id').change(function() {
        if($(this).val()==4) {
            $('.add-param-holder').slideDown();
        } else {
            $('.add-param-holder').slideUp();
        }
    });


    $('a.del_photo').live('click',function(){
        var firstClass = jQuery('a.del_gallery_item').attr('class').split(' ')[0];
        var model_id = firstClass.substring(8);
        if(!confirm('".Yii::t('item','Удалить главное фото?')."')) return false;
        jQuery.ajax({
            'url':'".$app->controller->createUrl('removeMainImage')."',
            'cache':false,
            'data':{id: model_id, image_id:$(this).attr('id')},
            'success':function(html){
                $('div#main-image-wrapper').html(html);
            }
        });         
        
        return false;
    });
    
    $('a.del_gallery_item').live('click',function(){
        var firstClass = jQuery('a.del_gallery_item').attr('class').split(' ')[0];
        var model_id = firstClass.substring(8);
        if(!confirm('".Yii::t('item','Удалить фото из галереи?')."')) return false;
        jQuery.ajax({
            'url':'".$app->controller->createUrl('removeGalleryImage')."',
            'cache':false,
            'data':{id: model_id, image_id:$(this).attr('id')},
            'success':function(html){
                $('div#main_gallery_holder').html(html);
            }
        }); 
        return false;
    });
    
        $('form#update-item-form input#Item_stretch').blur(function(){
            id=$(this).attr('id');
            jQuery.ajax({
                'url':'".Yii::app()->controller->createUrl('autoUpdateItemModel',array('id'=>$model->id))."',
                'dataType':'json',
                'type':'POST',
                'cache':false,
                'data':$('#update-item-form').serialize(),
                'success':function(data){
                    if(data.status=='success'){
                        $('form#update-item-form input#'+id).addClass('saved');
                    }   
                }
            });        
        });

",CClientScript::POS_READY);
?>

<?php
if(isset($_GET['movoToSize']))
    $app->clientScript
    ->registerScriptFile($baseUrl.'/static/js/scroll.js')
    ->registerScript(__FILE__,"
        $('body').scrollTo('#".$_GET['movoToSize']."');
    ",CClientScript::POS_LOAD);
?>