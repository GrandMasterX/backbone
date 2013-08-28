<div id="mailing-list-form" class="wide form">
    <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>($model->isNewRecord) ? 'create-mailingList-form' : 'update-mailingList-form',
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'class'=>'form-horizontal'
                    ),
                )); ?>

        <fieldset>
            <legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>

            <div class="control-group">
                <?php echo $form->labelEx($model,'title', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo $form->textField($model,'title',array('size'=>40)); ?>
                    <?php echo $form->error($model,'title'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'subject', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo $form->textField($model,'subject',array('size'=>40)); ?>
                    <?php echo $form->error($model,'subject'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'template_id', array('class'=>'control-label item-w')); ?>
                <div class="controls item-l-margin">
                    <?php echo Chosen::activeDropDownList($model, 'template_id', CHtml::listData(MailingListTemplate::model()->visible()->findAll(array('order'=>'title')), 'id', 'title'), 
                        array('empty'=>Yii::t('mailingList', 'Выберите из списка'))); ?> 
                    <?php echo $form->error($model,'template_id'); ?>
                </div>
            </div>
            
            <div class="control-group">
                <div class="controls item-l-margin">
                    <?php 
                        $this->widget('bootstrap.widgets.TbButton',array(
                            'label' => ($model->isNewRecord) ? Yii::t('mailingList', 'Создать') : Yii::t('mailingList', 'Обновить'),
                            'type' => 'success',
                            'buttonType'=>'submit',
                        ));
                        
                        $this->widget('bootstrap.widgets.TbButton',array(
                            'label' => ($model->isNewRecord) ? Yii::t('mailingList', 'Создать') : Yii::t('mailingList', 'Обновить'),
                            'type' => 'primary',
                            'buttonType'=>'submit',
                            'icon' => 'icon-user icon-white',
                            'htmlOptions'=>array(
                                'name'=>'movoToUsers',
                            ),
                        ));
                        
                        $this->widget('bootstrap.widgets.TbButton',array(
                            'label' =>Yii::t('mailingList', 'Отмена'),
                            'url'=>Yii::app()->controller->createUrl('index'),
                        ));                        
                    ?>
                </div>
            </div>

        </fieldset>
        
    <?php $this->endWidget(); ?>
</div>