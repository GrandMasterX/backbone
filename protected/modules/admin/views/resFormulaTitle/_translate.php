        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]title", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textField($translation,"[{$language_id}]title",array('size'=>100)); ?>
                <?php echo $form->error($translation,'title'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]user_title", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textField($translation,"[{$language_id}]user_title",array('size'=>100)); ?>
                <?php echo $form->error($translation,'user_title'); ?>
            </div>
        </div>        
       

