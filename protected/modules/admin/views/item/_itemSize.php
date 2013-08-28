<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>($itemSizeModel->isNewRecord) ? 'create-itemSize-form': 'update-itemSize-form_' . $itemSizeModel->id,
            'action'=>Yii::app()->controller->createUrl('updateItemSize',array('size_id'=>$itemSizeModel->id,'id'=>$item_id)),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>false,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'title', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'title',array('size'=>150, 'class'=>($itemSizeModel->isNewRecord) ? 'newRecord autoSave' : 'updateRecord')); ?>
                <?php echo $form->error($itemSizeModel,'title'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'birka', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'birka',array('size'=>150)); ?>
                <?php echo $form->error($itemSizeModel,'birkae'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwcb', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwcb',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwcb'); ?>
            </div>
        </div>        
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'il', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'il',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'il'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwss', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwss',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwss'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'bw', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'bw',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'bw'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwp',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwp'); ?>
            </div>
        </div>                         
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwa', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwa',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwa'); ?>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iww', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iww',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iww'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwar', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwar',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwar'); ?>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwwr', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwwr',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwwr'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwt', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwt',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwt'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'ils', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'ils',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'ils'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iws', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iws',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iws'); ?>
            </div>
        </div>

    <div class="control-group">
        <?php echo $form->labelEx($itemSizeModel,'iws2', array('class'=>'control-label item-w')); ?>
        <div class="controls item-l-margin">
            <?php echo $form->textField($itemSizeModel,'iws2',array('size'=>10)); ?>
            <?php echo $form->error($itemSizeModel,'iws2'); ?>
        </div>
    </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iltwo', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iltwo',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iltwo'); ?>
            </div>
        </div>


        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwsstwo', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwsstwo',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwsstwo'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'sup', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'sup',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'sup'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwap', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwap',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwap'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwwp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwwp',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwwp'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwtp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwtp',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'iwtp'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'cup', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'cup',array('size'=>10)); ?>
                <?php echo $form->error($itemSizeModel,'cup'); ?>
            </div>
        </div>

    <div class="control-group">
            <div class="controls item-l-margin">
                <?php echo $form->hiddenField($itemSizeModel,'item_id',array('size'=>10)); ?>
            </div>
        </div>        

		<div class="control-group">
			<div class="controls item-l-margin">
                <?php 
                    if ($itemSizeModel->isNewRecord):   
                    echo CHtml::ajaxSubmitButton(Yii::t('itemSize', 'Создать'),
                        '',
                        array(
                            'dataType'=>'json',
                            'type' => 'POST',
                            'data'=>'js:$("#create-itemSize-form").serialize()',
                            'success' => 'function(data){
                               if(data.status=="success"){
                                    $("div#sizeTab").html(data.html);
                               } else
                               {
                                $.each(data.error, function(key, val) {
                                    $("#create-itemSize-form #"+key+"_em_").text(val);                                                    
                                    $("#create-itemSize-form #"+key+"_em_").parent("div.controls").addClass("error");
                                    $("#create-itemSize-form #"+key+"_em_").show();
                                });
                               }
                            }',
                        ),
                        array(
                           'type' => 'submit',
                           'class'=>'btn btn-success',
                           'id'=>'saveNewSize_' . $itemSizeModel->id,
                        ));
                    endIf;  
                    ?>
                <?php 
                    if (!$itemSizeModel->isNewRecord):
                    echo CHtml::ajaxSubmitButton(Yii::t('language', 'Обновить'),
                        Yii::app()->controller->createUrl('updateItemSize',array('size_id'=>$itemSizeModel->id,'id'=>$item_id)), 
                        array(
                            'dataType'=>'json',
                            'type' => 'POST',
                            'data'=>'js:$("#update-itemSize-form_'.$itemSizeModel->id.'").serialize()',
                            'success' => 'function(data){
                               if(data.status=="success"){
                                    $("div#sizeTab").html(data.html);
                               } else
                               {
                                $.each(data.error, function(key, val) {
                                    $("#update-itemSize-form_'.$itemSizeModel->id.' #"+key+"_em_").text(val);                                                    
                                    $("#update-itemSize-form_'.$itemSizeModel->id.' #"+key+"_em_").parent("div.controls").addClass("error");
                                    $("#update-itemSize-form_'.$itemSizeModel->id.' #"+key+"_em_").show();
                                });
                               }
                            }',
                        ),
                        array(
                           'type' => 'submit',
                           'class'=>'btn btn-success',
                           'id'=>'updateSize_' . $itemSizeModel->id,
                        ));
                ?>
                &nbsp;
                <?php
                        echo CHtml::ajaxSubmitButton(Yii::t('language', 'Удалить'),
                            Yii::app()->controller->createUrl('deleteItemSize',array('id'=>$itemSizeModel->id, 'item_id'=>$item_id, 'delete'=>true)), 
                            array(
                                'type' => 'POST',
                                'beforeSend' => 'function(data){
                                    if(!confirm("'. Yii::t('itemSize', 'Вы уверены что хотите удалить этот размер?') .'")) return false;
                                }',                                
                                'success' => 'function(data){
                                   $("div#sizeTab").html(data);
                                }',
                            ),
                            array(
                               'type' => 'submit',
                               'class'=>'btn btn-warning',
                               'id'=>'deleteItemSize_' . $itemSizeModel->id,
                            ));                          
                ?>
                    &nbsp;
                <?php  endIf; ?>
                <?php
                    echo CHtml::ajaxSubmitButton(Yii::t('itemSize', 'Отмена'),
                        Yii::app()->controller->createUrl('reloadTabs',array('id'=>$item_id)), 
                        array(
                            'type' => 'POST',
                            'success' => 'function(data){
                               $("div#sizeTab").html(data);
                            }',
                        ),
                        array(
                           'type' => 'submit',
                           'class'=>'btn',
                           'id'=>'reloadTabs_' . $itemSizeModel->id,
                        ));                         
                ?>                                
            </div>
		</div>

<?php $this->endWidget(); ?>

<?php
    $app=Yii::app();
    $baseUrl=$app->baseUrl;

    $app->clientScript
        ->registerCoreScript('jquery')
        ->registerScript(__FILE__,"
        $('input#ItemSize_title').live('click',function(){
            if(this.value == this.defaultValue){
                this.select();
            }            
        });
        
        $('form#update-itemSize-form_".$itemSizeModel->id." input').blur(function(){
            id=$(this).attr('id');
            formData=$(this).closest('form').serialize();
            jQuery.ajax({
                'url':'".Yii::app()->controller->createUrl('autoUpdate',array('size_id'=>$itemSizeModel->id,'id'=>$item_id))."',
                'dataType':'json',
                'type':'POST',
                'cache':false,
                'data':formData,
                'success':function(data){
                    if(data.status=='success'){
                        $('form#update-itemSize-form_".$itemSizeModel->id." input#'+id).addClass('saved');
                        $('#update-itemSize-form_".$itemSizeModel->id." #'+id+'_em_').parent('div.controls').removeClass('error');
                        $('#update-itemSize-form_".$itemSizeModel->id." #'+id+'_em_').hide();
                    } else
                    {
                     $.each(data.error, function(key, val) {
                         $('#update-itemSize-form_".$itemSizeModel->id." #'+key+'_em_').text(val);                                                    
                         $('#update-itemSize-form_".$itemSizeModel->id." #'+key+'_em_').parent('div.controls').addClass('error');
                         $('#update-itemSize-form_".$itemSizeModel->id." #'+key+'_em_').show();
                     });
                   }                    
                }
            });        
        });         
        
    ",CClientScript::POS_READY);
?>