<?php 
$new_form=false;
if (!isset($form)) 
    {
        $form=$this->beginWidget('CActiveForm');     
        $new_form=true;
    }
?>

<div id="content-for-<?php echo $itemSizeModel->id; ?>">
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'title', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'title',array('size'=>150, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'title'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'birka', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'birka',array('size'=>150, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'birkae'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwcb', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwcb',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwcb'); ?>
            </div>
        </div>        
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'il', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'il',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'il'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwss', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwss',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwss'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'bw', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'bw',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'bw'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwp',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwp'); ?>
            </div>
        </div>                                  
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwa', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwa',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwa'); ?>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iww', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iww',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iww'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwar', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwar',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwar'); ?>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwwr', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwwr',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwwr'); ?>
            </div>
        </div>        
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwt', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwt',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwt'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'ils', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'ils',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'ils'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iws', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iws',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iws'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iws2', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iws2',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iws2'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iltwo', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iltwo',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iltwo'); ?>
            </div>
        </div>


        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwsstwo', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwsstwo',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwsstwo'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'sup', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'sup',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'sup'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwap', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwap',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwap'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwwp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwwp',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwwp'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'iwtp', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'iwtp',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'iwtp'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'vsl', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'vsl',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'vsl'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'cup', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'cup',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'cup'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'vpr', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'vpr',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'vpr'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($itemSizeModel,'rpli', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($itemSizeModel,'rpli',array('size'=>10, 'readonly'=>'true')); ?>
                <?php echo $form->error($itemSizeModel,'rpli'); ?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls item-l-margin">
                <?php echo $form->hiddenField($itemSizeModel,'item_id',array('size'=>10, 'readonly'=>'true')); ?>
            </div>
        </div>        

        <div class="control-group">
            <div class="controls item-l-margin">
                <?php 
                    echo CHtml::ajaxSubmitButton(Yii::t('language', 'Редактировать'),
                        Yii::app()->controller->createUrl('updateItemSize',array('size_id'=>$itemSizeModel->id,'id'=>$item_id)), 
                        array(
                            'type' => 'POST',
                            'data'=>'js:$("#create-itemSize-form").serialize()',
                            'success' => 'function(data){
                               $("div.size-tab-holder-item div.tab-content div.active").html(data);
                            }',
                        ),
                        array(
                           'type' => 'submit',
                           'class'=>'btn btn-success',
                           'id'=>'generateFormForUpdate_' . $itemSizeModel->id,
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
                           'class'=>($itemSizeModel->isNewRecord) ? 'btn' : 'btn btn-warning',
                           'id'=>'deleteItemSize_' . $itemSizeModel->id,
                        ));                         
                                        
                ?>
            </div>
        </div>
</div>
<?php if ($new_form) 
        $this->endWidget();
?>
