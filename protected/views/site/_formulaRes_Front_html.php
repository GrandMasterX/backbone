                <div id="formula_<?php echo $model->id; ?>" class="res-formula-range">
                    <div class="f-left">
                          <div class="input_wrapper" style="display:none">
                                <div class="control-group formula">
                                    <div class="controls">
                                        <div class="input-inline-wrapper">
                                            <div class="input-inline-left">
                                            </div>
                                            <div class="input-inline-right">
                                                <?php echo $form->textField($model,'fvalue',array('size'=>50, 'class'=>$model->id . ' fvalue')); ?>
                                                <?php echo $form->hiddenField($model,'rangeTitle', array('class'=>'rangeTitle')); ?>
                                            </div>
                                            <div class="both"></div>
                                        </div>
                                        <?php echo $form->hiddenField($model,'id'); ?>
                                    </div>
                                </div>
                          </div>
                          <div class="res-f-title"><?php echo $model->rangeTitleTranslationForUser; ?></div>
                          <div class="size_wrapper">
                              <!--size evaluation here-->
                              <div class="res-formula-holder">
                                <div class="range-holder">
                                    <div class="td-range minus-m" style="visibility:hidden"></div>
                                    <div class="td-range minus" style="visibility:hidden"></div>
                                    <div class="td-range plus" style="visibility:hidden"></div>
                                    <div class="td-range plus-m" style="visibility:hidden"></div>
                                </div>
                                <img src="<?php echo Yii::app()->getBaseUrl()?>/static/img/resFormula/line-full-<?php echo Yii::app()->language; ?>.png" border="0" width="589" height="44">
                              </div>
                          </div>
                      </div>
<!--                      <div class="f-right">
                        <div class="f-del"><a id="<?php //echo $model->id; ?>" href="#" class="f-del-a res-f"></a></div>
                      </div>
                      <div class="both"></div>  -->
                </div> 
                               
