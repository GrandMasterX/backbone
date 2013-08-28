<?php 
    if($models):?>
            <?php foreach($models as $model):?>
                <div class="portlet-f <?php echo ($model->type==4) ? 'parent' : 'child'?>">
                <?php if($model->type==1):?>
                    <div class="portlet-header"><?php echo Yii::t('formula','Расчетная формула');?></div>
                <?php elseIf($model->type==2):?>
                    <div class="portlet-header"><?php echo Yii::t('formula','Оценочная формула (диапазонная)');?></div>
                <?php elseIf($model->type==3):?>
                    <div class="portlet-header"><?php echo Yii::t('formula','Оценочная формула (графическая)');?></div>                        
                <?php elseIf($model->type==4):?>
                    <div class="portlet-header"><?php echo Yii::t('formula','Цепочка');?></div>                      
                <?php endIf;?>
                    <div class="portlet-content">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'formula-form_' . $model->id,
                                'enableAjaxValidation'=>true,
                                'enableClientValidation'=>true,
                                'clientOptions'=>array(
                                    'validateOnSubmit'=>true,
                                    'validateOnChange'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'class'=>$model->id,
                                    ),
                                )); ?>
                                <?php if($model->type==1):?>
                                    <?php $this->renderPartial('/formula/_formula_html',array(
                                        'model'=>$model, 
                                        'form'=>$form,
                                        'sizeList'=>$sizeList,
                                        )
                                    );?>
                                <?php endIf;?>                        

                                <?php if($model->type==2):?>
                                    <?php $this->renderPartial('/formula/_formulaRes_html',array(
                                        'model'=>$model, 
                                        'form'=>$form,
                                        )
                                    );?>
                                <?php endIf;?>
                                
                                <?php if($model->type==3):?>
                                    <?php $this->renderPartial('/formula/_formulaRes_html',array(
                                        'model'=>$model, 
                                        'form'=>$form,
                                        )
                                    );?>
                                <?php endIf;?>                                
                                
                                <?php if($model->type==4):?>
                                    <?php $this->renderPartial('/formula/_formulaParent_html',array(
                                        'model'=>$model, 
                                        'form'=>$form,
                                        'sizeList'=>$sizeList,
                                        )
                                    );?>
                                <?php endIf;?>                                 
                        <?php $this->endWidget(); ?>
                    
                    
                      <div id="child-wrapper-outer" style="display:none">
                          <?php if($model->children):?>
                          <div id="column-p" class="column-p">  
                          <?php foreach($model->children as $child):?>
                            <div class="portlet-f <?php echo ($child->type==4) ? 'parent' : 'child'?>">
                            <?php if($child->type==1):?>
                                <div class="portlet-header"><?php echo Yii::t('formula','Расчетная формула');?></div>
                            <?php elseIf($child->type==2):?>
                                <div class="portlet-header"><?php echo Yii::t('formula','Оценочная формула (диапазонная)');?></div>
                            <?php elseIf($child->type==3):?>
                                <div class="portlet-header"><?php echo Yii::t('formula','Оценочная формула (графическая)');?></div>                        
                            <?php elseIf($child->type==4):?>
                                <div class="portlet-header"><?php echo Yii::t('formula','Цепочка');?></div>                      
                            <?php endIf;?>
                                <div class="portlet-content">                          
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'formula-form_' . $child->id,
                                        'enableAjaxValidation'=>true,
                                        'enableClientValidation'=>true,
                                        'clientOptions'=>array(
                                            'validateOnSubmit'=>true,
                                            'validateOnChange'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'class'=>$child->id,
                                            ),
                                        )); ?>
                                        <?php if($child->type==1):?>
                                            <?php $this->renderPartial('/formula/_formula_html',array(
                                                'model'=>$child, 
                                                'form'=>$form,
                                                'sizeList'=>$sizeList,
                                                )
                                            );?>
                                        <?php endIf;?>                        

                                        <?php if($child->type==2):?>
                                            <?php $this->renderPartial('/formula/_formulaRes_html',array(
                                                'model'=>$child, 
                                                'form'=>$form,
                                                )
                                            );?>
                                        <?php endIf;?>
                                        
                                        <?php if($child->type==3):?>
                                            <?php $this->renderPartial('/formula/_formulaRes_html',array(
                                                'model'=>$child, 
                                                'form'=>$form,
                                                )
                                            );?>
                                        <?php endIf;?>                                
                                        
                                        <?php if($child->type==4):?>
                                            <?php $this->renderPartial('/formula/_formulaParent_html',array(
                                                'model'=>$child, 
                                                'form'=>$form,
                                                )
                                            );?>
                                        <?php endIf;?>                                 
                                <?php $this->endWidget(); ?>                                
                                </div>                     
                           </div>                          
                          <?php endForeach;?>
                          </div>
                          <?php elseIf($model->type==4): ?>
                          <div id="child-wrapper">
                            <div class="text-info">В этой цепочке нет формул</div>
                          </div>
                          <?php endIf; ?>
                      </div>                     
                    
                    
                    </div>
                </div>
                <?php endForeach; ?>    
    <?php else: ?>
        <div class="no-formula">
            <?php echo Yii::t('formula', 'Нет формул'); ?>
        </div>
    <?php endIf; ?>
    
    

    