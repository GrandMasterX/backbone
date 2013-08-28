        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]title", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textField($translation,"[{$language_id}]title",array('size'=>100)); ?>
                <?php echo $form->error($translation,'title'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]short_title", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textField($translation,"[{$language_id}]short_title",array('size'=>100)); ?>
                <?php echo $form->error($translation,'short_title'); ?>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]video_url", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textField($translation,"[{$language_id}]video_url",array('size'=>100)); ?>
                <?php echo $form->error($translation,'video_url'); ?>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]video_text", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textArea($translation,"[{$language_id}]video_text",array('size'=>100)); ?>
                <?php echo $form->error($translation,'video_text'); ?>
            </div>
        </div>                           

