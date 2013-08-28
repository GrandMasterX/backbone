        <div class="control-group">
            <?php echo $form->labelEx($translation,"[{$language_id}]title", array('class'=>'control-label t-lable-item')); ?>
            <div class="controls t-item-l-margin">
                <?php echo $form->textArea($translation,"[{$language_id}]title"); ?>
                <?php echo $form->error($translation,'title'); ?>
            </div>
        </div>

