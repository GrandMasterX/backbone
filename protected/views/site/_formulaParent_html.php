                <div id="formula_<?php echo $model->id; ?>" style="display:none">
                    <div class="f-left">
                          <div class="input_wrapper">
                                <div class="control-group formula">
                                        <span class="closed-f left"><a id="<?php echo $model->id; ?>" href="#" class="open-parent-f"></a></span>
                                    <?php echo $form->labelEx($model,'title', array('class'=>'control-label parent')); ?>
                                    <div class="controls">
                                        <div class="input-inline-wrapper">
                                            <div class="input-inline-left">
                                                <?php echo $form->textField($model,'title',array('size'=>255, 'class'=>$model->id . ' formula_title')); ?>
                                                <?php echo $form->error($model,'title'); ?>
                                            </div>
                                            <div class="input-inline-right">
                                            </div>
                                            <div class="both"></div>
                                        </div>
                                        <?php echo $form->hiddenField($model,'id'); ?>
                                    </div>
                                </div>
                          </div>
                      </div>
                      <div class="f-right">
                        <div class="f-del"><a id="<?php echo $model->id; ?>" href="#" class="f-del-a parent"></a></div>
                      </div>
                      <div class="both"></div>
                      <input type="checkbox"  id="<?php echo $model->id; ?>" value="<?php echo $model->id; ?>" class="p-chbox <?php if($model->type==4):?>parent<?php endIf; ?>">
                </div>
