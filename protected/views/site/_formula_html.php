                <div id="formula_<?php echo $model->id; ?>" style="display:none">
                    <div class="f-left">
                          <input type="checkbox"  id="<?php echo $model->id; ?>" value="<?php echo $model->id; ?>" class="f-chbox <?php if(is_null($model->parent)):?>no-parent<?php endIf; ?>">
                          <div class="input_wrapper">
                                <div class="control-group formula">
                                    <?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <div class="input-inline-wrapper">
                                            <div class="input-inline-left">
                                                <?php echo $form->textField($model,'title',array('size'=>255, 'class'=>$model->id . ' formula_title')); ?>
                                                <?php echo $form->error($model,'title'); ?>
                                            </div>
                                            <div class="input-inline-right">
                                                <?php if($model->is_locked==0): ?>
                                                    <?php echo $form->textField($model,'tag',array('size'=>50, 'class'=>$model->id . ' formula_tag')); ?>
                                                    <?php echo $form->error($model,'tag'); ?>
                                                <?php else: ?>
                                                    <?php echo $form->textField($model,'fvalue',array('size'=>50, 'class'=>$model->id . ' fvalue')); ?>
                                                <?php endIf; ?>
                                            </div>
                                            <div class="both"></div>
                                        </div>
                                        <?php echo $form->hiddenField($model,'id'); ?>
                                    </div>
                                </div>
                                <?php if($model->is_locked==0): ?>
                                <div class="control-group formula">
                                    <?php echo $form->labelEx($model,'value', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model,'value',array('size'=>255, 'class'=>$model->id . ' formula_value')); ?>
                                        <span id="vis_<?php echo $model->id; ?>" class="f-vis"></span>
                                        <?php echo $form->error($model,'value'); ?>
                                    </div>
                                </div>
                                <?php endIf; ?>            
                          </div>
                          <div class="size_wrapper">
                              <?php if(isset($sizeList) && !empty($sizeList)): ?>
                                  <div class="f-size-holder up">
                                      <?php foreach($sizeList as $size):?>
                                        <div class="size-cell"><?php echo $size->title; ?></div>
                                      <?php endForeach;?>
                                      <div class="both"></div><!--neede-->   
                                  </div>
                                  <div class="both"></div><!--needed-->

                                  <div class="f-size-holder">
                                      <?php foreach($sizeList as $size):?>
                                        <div id="res_<?php echo $size->title; ?>_<?php echo $model->id?>" class="size-cell"></div>
                                      <?php endForeach;?>
                                      <div class="both"></div><!--needed-->
                                  </div>
                                  <div class="both"></div><!--needed-->
                                  <div class="f-size-holder" style="display:none">
                                      <?php foreach($sizeList as $size):?>
                                        <div id="<?php echo $size->title; ?>_<?php echo $model->id?>" class="size-cell"></div>
                                      <?php endForeach;?>
                                      <div class="both"></div><!--needed-->
                                  </div>
                                  <div class="both"></div><!--needed-->                                  
                              <?php else: ?>
                                <div class="no-item-size text-info">
                                    <?php echo Yii::t('formula', 'Для отображения размеров необходимо или выбрать изделие или у изделия нет размеров'); ?>
                                </div>                                
                              <?php endIf; ?>
                          </div>
                      </div>
                      <div class="f-right">
                        <div class="f-del"><a id="<?php echo $model->id; ?>" href="#" class="f-del-a"></a></div>
                      </div>
                      <div class="both"></div>
                </div>
