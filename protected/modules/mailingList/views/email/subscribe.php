<?php
$this->pageTitle=($result)
    ? Yii::t('subscribe', 'Вы успешно подписались на рассылку')
    : Yii::t('subscribe', 'Произошла ошибка при попытке подписаться на рассылку');
?>
<div class="form-outer-holder">
    <div class="l-form-holder">
        <div class="login-form-holder">  
            <h2><?php echo $this->pageTitle ?></h2>
            <?php if ($result): ?>
                <div style="padding-left:10px"> 
                    <p class="text-success" style="text-align:center"><?php echo Yii::t('subscribe', 'Отписаться от рассылки Вы можете в личном кабинете или по ') . CHtml::link(Yii::t('subscribe', 'ссылке'), $this->createUrl('unsubscribe',array('id'=>$id,'ucode'=>$ucode)), array('class'=>'restore-link')); ?></p><br />
                </div>

            <?php else: ?>
                <div style="padding-left:10px"> 
                    <p class="text-error" style="text-align:center"><?php echo Yii::t('subscribe', 'Возникла ошибка при попытке подписаться на рассылку!'); ?></p><br />
                    <div style="text-align:center"><?php echo CHtml::link(Yii::t('subscribe', 'Повторить'), $this->createUrl('subscribe',array('id'=>$id,'ucode'=>$ucode)), array('class'=>'restore-link')); ?></div>
                </div>
            <?php endif ?>       
        </div>
    </div>
</div>