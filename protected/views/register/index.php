  <div class="row-fluid marketing register">
<!--    <div class="span6 form-holder">-->
        
<!--    </div>-->
    <?php $page=Yii::app()->request->getQuery('page');?>
    <div class="span6 first-time center <?php if($page=='login'):?>hide<?php endIf;?>">
      <div class="text">
      <?php if(isset($item_id) && !is_null($item_id)):?>
          <?php echo Yii::t('register', '<h3>Впервые с AstraFit ?</h3><p>Давайте измерим Вас.</p>');?>
          <?php echo CHtml::link(CHtml::encode(Yii::t('register', 'Продолжить')),array('sizeTour?type_id='.$type_id.'&item_id='.$item_id),array('class'=>'btn btn-success btn-large','title'=>Yii::t('register', 'Продолжить'))); ?>
          <div class="login-cab"><?php echo CHtml::link(CHtml::encode(Yii::t('register', 'Вход в кабинет')),array('#'),array('id'=>'to-login','class'=>'','title'=>Yii::t('register', 'Вход  в кабинет'))); ?></div>
      <?php endIf; ?> 
      </div>       
    </div>    

    <div class="form-holder reg-login-holder <?php if($page!='login'):?>hide<?php endIf;?>">
        <?php $this->renderPartial('loginForm', array('model'=>$model)); ?>
    </div>
    
  </div>
  
<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScript(__FILE__,"
    
    $('.restore-link-front').live('click', function() {".
         CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('restorePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
               $('.form-holder').append(data).find('form#restore-pass-form').fadeIn();
               $('form#login-form').hide();
            }"
         ))
    ."});

    $('.login-link').live('click', function() {
       $('form#restore-pass-form').add('div#restorePassSucces').remove();
       $('form#login-form').fadeIn();
    });
    
    
    $('#to-login,#to-register').on('click',function() {
        $('.first-time').toggleClass('hide show');
        $('.reg-login-holder').toggleClass('hide show')
        return false;
    });
    
", CClientScript::POS_READY
);    
?>   