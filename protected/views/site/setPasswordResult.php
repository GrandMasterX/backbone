<?php
$this->pageTitle=Yii::t('setPasswordForm', 'Установка пароля');
if($type==1)
    $url=$this->createUrl('register/index');
else
    $url=$this->createUrl('site/login');
?>
<div class="form-outer-holder">
    <div class="l-form-holder">
        <div class="login-form-holder">  
            <h2><?php echo $this->pageTitle ?></h2>
            <?php if (isset($result) && $result): ?>
                <div style="padding-left:10px"> 
                    <p class="text-success" style="text-align:center"><?php echo Yii::t('setPasswordForm', 'Пароль успешно установлен!'); ?></p><br />
                    <!--<div style="text-align:center"><?php //echo CHtml::link(Yii::t('setPasswordResult', 'Перейти к авторизации'), $url, array('class'=>'login-link')); ?></div>-->
                </div>

            <?php else: ?>
                <div style="padding-left:10px"> 
                    <p class="text-error" style="text-align:center"><?php echo Yii::t('setPasswordForm', 'Возникла ошибка при установке пароля!'); ?></p><br />
                    <div style="text-align:center"><?php echo CHtml::link(Yii::t('loginForm', 'Повторить'), $this->createUrl('site/restorePassword'), array('class'=>'restore-link')); ?></div>
                </div>
            <?php endif ?>       
        </div>
    </div>
</div>