<?php if(isset($model)):
    $form=$this->beginWidget('CActiveForm', array(
            'id'=>'range_edit_'.$model->key,
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnChange'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>$model->key,
                ),
            )); ?>
    <table id="<?php echo $model->key; ?>" valign="MIDDLE" class="<?php echo ($model->key>0) ? 'top-margin':'' ?>">   
        <tr id="<?php echo $model->key; ?>">
          <td>
            <?php echo $form->hiddenField($model,'key',array('size'=>3)); ?>
            <?php echo $form->hiddenField($model,'type_id',array('size'=>3)); ?>
            <?php echo $form->hiddenField($model,'title',array('size'=>3)); ?>
            <?php echo $form->textField($model,'min',array('size'=>3)); ?>
          </td>
          <td>
            <?php echo $form->textField($model,'minr',array('size'=>3)); ?>
          </td>
          <td>
          <?php echo $form->textField($model,'maxr',array('size'=>3)); ?>
          </td>
          <td>
          <?php echo $form->textField($model,'max',array('size'=>3)); ?>
          </td>          
          <td>
             <a href="#" class="range-update" title='<?php echo Yii::t('range', 'Сохранить')?>'><?php echo Yii::t('range', 'Ок')?></a>
          </td>
        </tr>
    </table> 
<?php 
    $this->endWidget(); 
    endIf;
?>
