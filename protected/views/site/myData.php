<?php
$this->pageTitle = Yii::t('cabinet', 'Кабинет');
$this->breadcrumbs = array(
    $this->pageTitle,
);
?>
<?php if ($returnToModel): ?>
    <ul style="float:right;margin-top: -48px;margin-right:20px;">
        <li>
            <?php echo CHtml::link(Yii::t('index', CHtml::encode('Вернуться к товару')), array($returnToModel), array('class' => 'top-menu', 'title' => Yii::t('index', 'Вернуться к товару'))); ?>
        </li>
    </ul>
<?php endif; ?>
<div class="inner-container">
    <!--Alerts-->
    <div class="alert alert-success my-alert" style="display:none">
<!--        <button type="button" class="close" data-dismiss="alert">&times;</button>-->
        <div class="inner-m-text"></div>
    </div>
    <div class="well">   
        <ul class="nav nav-tabs">
            <li class="<?php if (is_null(Yii::app()->request->getQuery('private'))) : ?> active <?php endIf; ?>"><a href="#my-size" data-toggle="tab"><?php echo Yii::t('cabinet', 'Мои размеры') ?></a></li>
            <li class="<?php if (Yii::app()->request->getQuery('private')): ?> active <?php endIf; ?>"><a href="#profile" data-toggle="tab"><?php echo Yii::t('cabinet', 'Личные данные') ?></a></li>
            <li><a href="#pass" data-toggle="tab"><?php echo Yii::t('cabinet', 'Пароль') ?></a></li>
            <li><a href="#options" data-toggle="tab"><?php echo Yii::t('cabinet', 'Настройки') ?></a></li>
        </ul>
        <div id="myTabContent my-data" class="tab-content">

            <div class="tab-pane <?php if (is_null(Yii::app()->request->getQuery('private'))) : ?> active in <?php else: ?> fade <?php endIf; ?>" id="my-size">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'client-size-form',
                    'enableAjaxValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-horizontal'
                    ),
                ));
                ?>
                <?php foreach ($listOfClientSizeModelsForUpdate as $i => $item): ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($item['model'], "[$i]value", array('class' => 'control-label item-w', 'label' => $item['model']->label)); ?>
                        <div class="controls item-l-margin">
                            <?php echo $form->textField($item['model'], "[$i]value", array('size' => 40)); ?>
                            <?php echo $form->error($item['model'], "[$i]value"); ?>
                            <?php echo $form->hiddenField($item['model'], "[$i]size_id", array('size' => 40)); ?>
                        </div>
                    </div>            
                    <?php endForeach; ?>                        

                <div class="control-group"> 
                    <div class="controls">
                        <?php
                        echo CHtml::ajaxSubmitButton(Yii::t('adminUser', 'Сохранить'), '', array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'data' => 'js:$("#client-size-form").serialize()',
                            'success' => 'function(data){
                                        if(data.status=="success"){
                                            $(".my-alert")         
                                                .find(".inner-m-text")
                                                .html(data.message)
                                                .end()
                                                .show()
                                                .animate({opacity: 1.0}, 3000)
                                                .fadeOut("slow");
                                        } else {
                                            $(".my-alert")         
                                                .find(".inner-m-text")
                                                .html(data.message)
                                                .end()
                                                .show()
                                                .animate({opacity: 1.0}, 3000)
                                                .fadeOut("slow");
                                         $.each(data, function(key, val) {
                                             $("#"+key+"_em_").text(val);                                                    
                                             $("#"+key+"_em_").parent("div.controls").addClass("error");
                                             $("#"+key+"_em_").show();
                                         });
                                       }
                                    }',
                                ), array(
                            'id' => 'client-size-form-btn',
                            'type' => 'submit',
                            'class' => 'btn btn-success'
                        ));
                        ?> 
                    </div>
                </div>            
                <?php $this->endWidget(); ?>
            </div>        

            <div class="tab-pane <?php if (Yii::app()->request->getQuery('private')) : ?> active in <?php else: ?> fade <?php endIf; ?>" id="profile">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'client-data-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-horizontal'
                    ),
                ));
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'control-label item-w')); ?>
                    <div class="controls item-l-margin"> 
                        <?php echo $form->textField($model, 'name', array('size' => 40)); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'control-label item-w')); ?>
                    <div class="controls item-l-margin"> 
                        <?php echo $form->textField($model, 'phone', array('size' => 40)); ?>
                        <?php echo $form->error($model, 'phone'); ?>
                    </div>
                    <?php echo CHtml::hiddenField('ajax', 'client-data-form', array('size' => 16)); ?>
                </div>
                <div class="control-group"> 
                    <div class="controls">
                        <?php
                        echo CHtml::ajaxSubmitButton(Yii::t('adminUser', 'Сохранить'), '', array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'data' => 'js:$("#client-data-form").serialize()',
                            'success' => 'function(data){
                                        if(data.status=="success"){
                                            $(".my-alert")
                                                .find(".inner-m-text")
                                                .html(data.message)
                                                .end()
                                                .show()
                                                .animate({opacity: 1.0}, 3000)
                                                .fadeOut("slow");
                                        } else {
                                         $.each(data, function(key, val) {
                                             $("#"+key+"_em_").text(val);                                                    
                                             $("#"+key+"_em_").parent("div.controls").addClass("error");
                                             $("#"+key+"_em_").show();
                                         });
                                       }
                                    }',
                                ), array(
                            'id' => 'client-data-form-btn',
                            'type' => 'submit',
                            'class' => 'btn btn-success'
                        ));
                        ?> 
                    </div>
                </div>            
                <?php $this->endWidget(); ?>
            </div>

            <div class="tab-pane fade" id="pass">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'client-password-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-horizontal'
                    ),
                ));
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'password_check', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->passwordField($model, 'password_check', array('size' => 40)); ?> 
                        <?php echo $form->error($model, 'password_check'); ?>
                    </div>
                </div>         

                <div class="control-group">   
                    <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
                    <div class="controls">  
                        <?php echo $form->passwordField($model, 'password', array('size' => 40)); ?> 
                        <?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>

                <div class="control-group">  
                    <?php echo $form->labelEx($model, 'password_repeat', array('class' => 'control-label')); ?>
                    <div class="controls">  
                        <?php echo $form->passwordField($model, 'password_repeat', array('size' => 40)); ?>
                        <?php echo $form->error($model, 'password_repeat'); ?>
                    </div>
                    <?php echo CHtml::hiddenField('ajax', 'client-password-form', array('size' => 16)); ?>
                </div>                

                <div class="control-group"> 
                    <div class="controls">
                        <?php
                        echo CHtml::ajaxSubmitButton(Yii::t('adminUser', 'Сменить пароль'), '', array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'data' => 'js:$("#client-password-form").serialize()',
                            'success' => 'function(data){
                                        if(data.status=="success"){
                                            $(".my-alert")
                                                .find(".inner-m-text")
                                                .html(data.message)
                                                .end()
                                                .show()
                                                .animate({opacity: 1.0}, 3000)
                                                .fadeOut("slow");
                                        } else {
                                         $.each(data, function(key, val) {
                                             $("#"+key+"_em_").text(val);                                                    
                                             $("#"+key+"_em_").parent("div.controls").addClass("error");
                                             $("#"+key+"_em_").show();
                                         });
                                       }
                                    }',
                                ), array(
                            'id' => 'change-password-btn',
                            'type' => 'submit',
                            'class' => 'btn btn-success'
                        ));
                        ?>                        

                    </div>
                </div>            
                <?php $this->endWidget(); ?>
            </div>

            <div class="tab-pane" id="options">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'client-options-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-horizontal'
                    ),
                ));
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mailing', array('class' => 'control-label item-w')); ?>
                    <div class="controls item-l-margin"> 
                        <?php echo $form->checkBox($model, 'mailing'); ?>
                    </div>
                    <?php echo CHtml::hiddenField('ajax', 'client-options-form', array('size' => 19)); ?>
                </div>

                <div class="control-group"> 
                    <div class="controls">
                        <?php
                        echo CHtml::ajaxSubmitButton(Yii::t('adminUser', 'Сохранить'), '', array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'data' => 'js:$("#client-options-form").serialize()',
                            'success' => 'function(data){
                                        if(data.status=="success"){
                                            $(".my-alert")
                                                .find(".inner-m-text")
                                                .html(data.message)
                                                .end()
                                                .show()
                                                .animate({opacity: 1.0}, 3000)
                                                .fadeOut("slow");
                                        } else {
                                         $.each(data, function(key, val) {
                                             $("#"+key+"_em_").text(val);                                                    
                                             $("#"+key+"_em_").parent("div.controls").addClass("error");
                                             $("#"+key+"_em_").show();
                                         });
                                       }
                                    }',
                                ), array(
                            'id' => 'client-options-form-btn',
                            'type' => 'submit',
                            'class' => 'btn btn-success'
                        ));
                        ?> 
                    </div>
                </div>            
                <?php $this->endWidget(); ?>
            </div>


        </div>
    </div>
</div>
<?php
$app = Yii::app();
$baseUrl = $app->baseUrl;

$app->clientScript
        ->registerCoreScript('jquery')
        ->registerScriptFile($baseUrl . '/static/admin/debug/print_r.js')
        ->registerScript(__FILE__, "
    
   
    
    ", CClientScript::POS_READY
);
?> 