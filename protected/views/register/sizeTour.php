<!--modal-->
    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'getSizeModal', 'autoOpen'=>'true')); ?>
     
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('sizeTour', 'Важная информация'); ?></h4>
    </div>
     
    <div class="modal-body">
          <?php echo Yii::t('sizeTour', '
          <p>Процесс обмера займет буквально минуту.<br />
          Длительность каждого ролика не более 10-15 сек.</p>
          <p>Пожалуйста обратите внимание, что точность подбора размера зависит от того, насколько вы себя правильно измерите согласно видео-инструкций.</p>
          ');?>
    </div>
     
    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'primary',
            'label'=>Yii::t('sizeTour', 'Продолжить'),
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal'),
        )); ?>
    </div>
     
    <?php $this->endWidget(); ?>
<!--modal end-->

<div id="videos-holder" class="row-fluid">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'registration',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:afterFormValidateFunction',     
        ),
        'htmlOptions'=>array(    
            'enctype' => 'multipart/form-data',
            ),
        )); ?> 
    <div class="span12 center">
        <ul>
            <li>
                <div id="" class="video-holder">
                    <iframe id="p_intro" src="http://player.vimeo.com/video/<?php echo $intro; ?>?api=1&player_id=p_intro&autoplay=0" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>                
<!--                    <div id="player" class="embed">
                        <div id="loader" class="loading"></div>
                    </div>  -->
                     <div id="ht_<?php echo $intro;?>" class="helper-text"><?php echo Yii::t('sizeTour', 'Welcome to AstraFit!');?></div>
                    <div id="input-holder" class="input-container start-btn-holder pop-up">
                        <div class="control-group">
                            <div class="controls" style="text-align:center; margin-top:20px;">
                                <?php echo CHtml::button(Yii::t('sizetour', 'Перейти к размерам'), array('class'=>'btn btn-success btn-large next-btn first')); ?>
                                <?php echo CHtml::hiddenField('session_id',$session_id,array('id'=>'session_id'))?>
                            </div>
                        </div> 
                    </div>
                </div><!--video-holder-->
            </li>
            <?php $ii=1; foreach($sizeList as $i=>$item): ?>
            <li class="<?php echo $i;?>" style="display:none">
                <div id="<?php echo $item['model']->size_id ?>" class="video-holder">
                    <div id="player-container_<?php echo $i; ?>" class="embed player-container">
                        <div id="loader" class="loading"></div>
                    </div>
                    <div id="ht_<?php echo $item['model']->video_url;?>" class="helper-text"><?php echo $item['model']->video_text; ?></div>
                    <div id="input-holder" class="input-container start-btn-holder <?php if(count($sizeList)==$ii):?>over<?php endIf; ?> pop-up">
                        <div class="control-group">
                            <?php echo $form->labelEx($item['model'],"[$i]value", array('class'=>'control-label', 'label'=>$item['model']->label)); ?>
                            <div class="controls">
                                <?php echo $form->textField($item['model'],"[$i]value",array('size'=>40)); ?>
                                <?php if(count($sizeList)!=$ii):?>
                                    <?php echo CHtml::button(Yii::t('sizetour', 'Дальше'), array('id'=>$item['model']->video_url,'class'=>'btn btn-success next-btn vid-id')); ?>
                                <?php endIf; ?>  
                                <?php echo $form->error($item['model'],"[$i]value"); ?>
                                <?php echo $form->hiddenField($item['model'],"[$i]size_id",array('size'=>40)); ?>
                            </div>
                        </div>
                        
                        <?php if(count($sizeList)==$ii):?>
                            <div class="control-group">
                                <div>
                                    <div class="left">
                                        <?php echo $form->labelEx($user,"email", array('class'=>'control-label')); ?>
                                    </div>
                                    <div class="left">
                                        <a href="#" id="e-tooltip" class="e-tooltip" rel="tooltip" title="<?php echo Yii::t('sizeTour', 'На ваш email будет создан акканут, в котором будут сохранены все введенные параметры.');?>"><?php echo Yii::t('sizeTour', 'Зачем?');?></a>
                                    </div>
                                    <div class="both"></div>
                                </div>
                                <div class="controls">
                                    <?php echo $form->textField($user,"email",array('size'=>40)); ?>
                                    <?php echo $form->error($user,"email"); ?>                                                        
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo $form->labelEx($user,"password", array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->passwordField($user,'password'); ?>
                                    <?php echo $form->error($user,'password'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo $form->labelEx($user,"password_repeat", array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->passwordField($user,'password_repeat'); ?>
                                    <?php echo CHtml::submitButton(Yii::t('sizetour', 'Готово'), array('id'=>$item['model']->video_url,'class'=>'btn btn-success vid-id')); ?>
                                    <?php echo $form->error($user,'password_repeat'); ?>                                                        
                                </div>
                            </div>
                            <div class="control-group social" style="display:none;">
                                <?php //$this->widget('ext.hoauth.widgets.HOAuth'); ?>
                            </div>
                        <?php endIf; ?>
                         
                    </div>
                </div><!--video-holder-->
            </li>
            <?php $ii++; endForeach; ?>
        </ul>
    </div>

    <?php $this->endWidget(); ?> 
</div>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerScript(__FILE__,"
        
    window.introVideo='".$intro."';
    //window.introVideo='2woH10c8l_0';
    //Pw-l4FPscEM
    $('#ClientHasSize_7_value').change(function(){
        if($(this).val()!='')
            $('.social').show();
    });
    
    $('.social a').click(function(){
        setsession($('#ClientHasSize_7_value').val());
    });
    
    function setsession(sessdata){
    ".
        CHtml::ajax(array(
            'url' => CController::createUrl('register/Setsession', array()),
            'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,'size' => 'js: sessdata'),
            'dataType' => 'json',
            'type' => 'POST',
            'success' => "function(data){
                console.log('11');
            }"
        ))."
    }
    
    function afterFormValidateFunction(form, data, hasError) {
        var curid=$('.current').find('input:first').attr('id');
        var curids=$('.current').find(':input:text, input:password');
        //console.log('curids length' + curids.length);
        //console.log('curids dom' . curids);
        setsession($('#'+curid).parent('div').find('input:eq(0)').val());
        error=0;
        $.each( curids, function( key, value ) {
            //console.log('value' + value.id);
            if( data[value.id] !== undefined ) {
                error=1;
                return false;
            }
        });

        form.find('.controls')
          .removeClass('error');
        
        //console.log(print_r(data));
        
        if( error!=1 ) {
            //console.log('validated 1');
            btn=$('.current').find('input.next-btn');
            loadVideo(btn);
                
            form.find('.controls')
              .removeClass('current');

            $('#'+curid).closest('li')
                   .hide()
                   .next()
                   .show()
                   .find('.controls')
                   .addClass('current');               
        } else {
            //console.log('error 1');
        }
        if (empty(data)){
            return true;
        } 
        //else {
//            $.each(data, function(key, val) {  
                //skey=key.substring(0,13);
                //if (key !=curid) {
                    //$('[id^='+skey+']').text(val);
                    //$('[id^='+skey+']').parent('div.controls').removeClass('success').addClass('error');
                    //$('[id^='+skey+']').show();
                //}
//            });
//            
            //}         
        
        // Always return false so that Yii will never do a traditional form submit
//        return false;
    }
    
    ", CClientScript::POS_READY
);    
?>  