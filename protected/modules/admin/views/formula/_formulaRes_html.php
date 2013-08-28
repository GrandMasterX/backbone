                <div id="formula_<?php echo $model->id; ?>" class="res-formula-range">
                    <div class="f-left">
                    <input type="checkbox"  id="<?php echo $model->id; ?>" value="<?php echo $model->id; ?>" class="f-chbox res-formula range <?php if(is_null($model->parent)):?>no-parent<?php endIf; ?>">
                          <div class="input_wrapper">
                                <div class="control-group formula">
                                    <?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <div class="input-inline-wrapper">
                                            <div class="input-inline-left">
                                                <?php echo Chosen::activeDropDownList($model,'title', Formula::getListOfTitles(), array('class'=>$model->id . ' titleSelect','empty'=>Yii::t('formula', 'Выберите наименование'))); ?> 
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
                          <div class="size_wrapper">
                              <!--size evaluation here-->
                              <div class="res-formula-holder">
                                <div class="range-holder">
                                    <div class="td-range minus-m"></div>
                                    <div class="td-range minus"></div>
                                    <div class="td-range plus"></div>
                                    <div class="td-range plus-m"></div>
                                </div>
                                <img src="<?php echo Yii::app()->getBaseUrl()?>/static/img/resFormula/line-full.png" border="0" width="589" height="44">
                              </div>
                          </div>
                      </div>
                      <div class="f-right">
                        <div class="f-del"><a id="<?php echo $model->id; ?>" href="#" class="f-del-a res-f"></a></div>
                      </div>
                      <div class="both"></div>
                </div>
                               
