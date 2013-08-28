<?php
$this->pageTitle=($result)
    ? Yii::t('unsubscribe', 'Вы успешно отписались от рассылки')
    : Yii::t('unsubscribe', 'Произошла ошибка при попытке отписаться от рассылки');
?>
<div class="form-outer-holder">
    <div class="l-form-holder">
        <div class="login-form-holder">  
            <h2><?php echo $this->pageTitle ?></h2>
            <?php if ($result): ?>
                <div style="padding-left:10px"> 
                    <p class="text-success" style="text-align:center"><?php echo Yii::t('unsubscribe', 'Возобновить подписку Вы можете в личном кабинете или по ') . CHtml::link(Yii::t('unsubscribe', 'ссылке'), $this->createUrl('subscribe',array('id'=>$id,'ucode'=>$ucode)), array('class'=>'restore-link')); ?></p><br />
                </div>

            <?php else: ?>
                <div style="padding-left:10px"> 
                    <p class="text-error" style="text-align:center"><?php echo Yii::t('unsubscribe', 'Возникла ошибка при отписке от рассылки!'); ?></p><br />
                    <div style="text-align:center"><?php echo CHtml::link(Yii::t('unsubscribe', 'Повторить'), $this->createUrl('unsubscribe',array('id'=>$id,'ucode'=>$ucode)), array('class'=>'restore-link')); ?></div>
                </div>
            <?php endif ?>       
        </div>
    </div>
</div>