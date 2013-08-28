<?php
$this->pageTitle=Yii::t('adminUser', 'Редактирование пользователя');

$this->breadcrumbs=array(
	Yii::t('adminUser', 'Управление пользователями')=>array('index'),
	$this->pageTitle,
);
?>

<!-- Modal -->
<div id="ch_pass" class="modal hide" style="display: none; ">
    <div class="modal-header">
      <a class="close" data-dismiss="modal">×</a>
      <h3><?php echo Yii::t('formGeneral', 'Смена пароля')?></h3>
    </div>
    <div id="ch_pass_cont" class="modal-body" style="min-height:165px">
        <div id='c_load' class="ajax-loader"><img src="<?php echo Yii::app()->baseUrl ?>/static/img/ajax-loader.gif" /></div>
    </div>
    <div class="modal-footer">
      <?php
            echo CHtml::ajaxSubmitButton(Yii::t('adminUser', 'Сменить пароль'), 
                Yii::app()->controller->createUrl('changePassword',array()), 
                array(
                    'type' => 'POST',
                    'data'=>'js:$("#change-pass-form").serialize()',
                    'success' => 'function(data){
                       updateModal(data);
                    }',
                ),
                array(
                   'type' => 'submit',
                   'class'=>'btn btn-success'
                ));
      ?>
      <?php echo CHtml::button(Yii::t('adminUser', 'Отмена'), array('class'=>'btn', 'data-dismiss'=>'modal')); ?>
    </div>
</div>
<!-- Modal END -->  
<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="user-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'update-user-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>
    <fieldset>
        <legend><span class="left-margin"></span><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>
		<div class="control-group">
			<?php echo $form->labelEx($model,'name', array('class'=>'control-label')); ?>
			<div class="controls"> 
                <?php echo $form->textField($model,'name',array('size'=>40)); ?>
			    <?php echo $form->error($model,'name'); ?>
            </div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
			<div class="controls"> 
                <?php echo $form->textField($model,'email',array('size'=>40)); ?>
			    <?php echo $form->error($model,'email'); ?>
            </div>
		</div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'phone', array('class'=>'control-label')); ?>
            <div class="controls"> 
                <?php echo $form->textField($model,'phone',array('size'=>40)); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
        </div>
    
		<div class="control-group">
			<div class="controls"> 
                <?php echo CHtml::submitButton(Yii::t('adminUser', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('adminUser', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
                <?php if (Yii::app()->user->id == $uid) : ?>
                    <?php echo CHtml::button(Yii::t('adminUser', 'Сменить пароль'), array('id'=>'ch-pass-b','class'=>'btn btn-warning', 'data-toggle'=>'modal', 'data-target'=>'#ch_pass')); ?>
                <?php endif?>
            </div>
		</div>
    </fieldset>
<?php $this->endWidget(); ?>
</div>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScript(__FILE__,"
    
    $('#g_pass').live('click', function() {".
         CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('generatePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
               $('input#User_password').val(data);
               $('input#User_password_repeat').val(data);
            }"
         ))
    ."});
    
    $('#ch-pass-b').live('click', function() {".
         CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('changePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
            var data = jQuery.parseJSON(data);
            $('div#ch_pass_cont').html(data.html);
            }"
         ))
    ."});
    
    function updateModal(data) {
       var data = jQuery.parseJSON(data);
       if(data.status=='success'){
        $('#ch_pass').modal('hide');
        showMessage(data.html);
        //$('div#ch_pass_cont').empty();
        } else {
            $('div#ch_pass_cont').html(data.html);  
        }
    }    
    
    ", CClientScript::POS_READY
);    
?> 
