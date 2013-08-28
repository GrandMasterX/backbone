<?php echo CHtml::form('exel/index/upload', 'post', array('enctype'=>'multipart/form-data')); ?>
<?php echo CHtml::activeFileField($model, 'excel'); ?>
<?php echo CHtml::submitButton('Submit'); ?>
<?php echo CHtml::endForm(); ?>