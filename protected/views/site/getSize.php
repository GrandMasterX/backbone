<!--modal-->
    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'getSizeModal', 'autoOpen'=>'true')); ?>
     
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('getSize', 'Требуются дополнительные параметры'); ?></h4>
    </div>
     
    <div class="modal-body">
          <?php echo Yii::t('getSize', '
            Для оценки выбранного изделия не хватает данных по следуюшим параметрам вашего тела:<br />
          ');?>
          <?php
          foreach($sizeList as $item) {
            echo '<b>' . $item['model']->label . '</b><br />';
          }
          array_shift($sizeList);
          ?>
    </div>
     
    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'primary',
            'label'=>Yii::t('getSize', 'Начать'),
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal'),
        )); ?>
    </div>
     
    <?php $this->endWidget(); ?>
<!--modal end-->
  
  <div id="videos-holder" class="row-fluid">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'registration',
        'action'=>Yii::app()->createUrl('site/result',array('code'=>$code)),
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
            <?php $i=$first_video['model']->size_id;?>
            <li class="<?php echo $i;?>">
                <div id="<?php echo $first_video['model']->size_id ?>" class="video-holder">
                    <iframe id="<?php echo $first_video['model']->video_url;?>" src="http://player.vimeo.com/video/<?php echo $first_video['model']->video_url; ?>?api=1&player_id=<?php echo $first_video['model']->video_url;?>" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>                
<!--                    <div id="player" class="embed">
                        <div id="loader" class="loading"></div>
                    </div>  -->
                     <div class="helper-text"><?php echo $first_video['model']->video_text;?></div>
                    <div id="input-holder" class="input-container start-btn-holder pop-up">
                        <div class="control-group">
                            <?php echo $form->labelEx($first_video['model'],"[$i]value", array('class'=>'control-label', 'label'=>$first_video['model']->label)); ?>
                            <div class="controls current">
                                <?php echo $form->textField($first_video['model'],"[$i]value",array('size'=>40)); ?>
                                <?php if(count($sizeList)>0):?>
                                    <?php echo CHtml::button(Yii::t('sizetour', 'Дальше'), array('id'=>$first_video['model']->video_url,'class'=>'btn btn-success next-btn vid-id')); ?>
                                <?php elseIf(count($sizeList)==0): ?>  
                                    <?php echo CHtml::submitButton(Yii::t('sizetour', 'Готово'), array('id'=>$first_video['model']->video_url,'class'=>'btn btn-success vid-id')); ?>
                                <?php endIf; ?>  
                                <?php echo $form->error($first_video['model'],"[$i]value"); ?>
                                <?php echo $form->hiddenField($first_video['model'],"[$i]size_id",array('size'=>40)); ?>
                            </div>
                        </div>
                    </div>
                </div><!--video-holder-->
            </li>        
        
            <?php $ii=1; foreach($sizeList as $i=>$item): ?>
            <?php $i=$item['model']->size_id;?>
            <li class="<?php echo $item['model']->size_id;?>" style="display:none">
                <div id="<?php echo $item['model']->size_id ?>" class="video-holder">
                    <div id="player-container_<?php echo $i; ?>" class="embed player-container">
                        <div id="loader" class="loading"></div>
                    </div>
                    <div class="helper-text"><?php echo $item['model']->video_text; ?></div>
                    <div id="input-holder" class="input-container start-btn-holder pop-up">
                        <div class="control-group">
                            <?php echo $form->labelEx($item['model'],"[$i]value", array('class'=>'control-label', 'label'=>$item['model']->label)); ?>
                            <div class="controls">
                                <?php echo $form->textField($item['model'],"[$i]value",array('size'=>40)); ?>
                                <?php if(count($sizeList)!=$ii):?>
                                    <?php echo CHtml::button(Yii::t('sizetour', 'Дальше'), array('id'=>$item['model']->video_url,'class'=>'btn btn-success next-btn vid-id')); ?>
                                <?php elseIf(count($sizeList)==$ii): ?>  
                                    <?php echo CHtml::submitButton(Yii::t('sizetour', 'Готово'), array('id'=>$item['model']->video_url,'class'=>'btn btn-success vid-id')); ?>
                                <?php endIf; ?>  
                                <?php echo $form->error($item['model'],"[$i]value"); ?>
                                <?php echo $form->hiddenField($item['model'],"[$i]size_id",array('size'=>40)); ?>
                            </div>
                        </div>
                    </div>
                </div><!--video-holder-->
            </li>
            <?php $ii++; endForeach; ?>
        </ul>
    </div>
     <?php echo CHtml::hiddenField('item_id',$item_id);?>
    <?php $this->endWidget(); ?> 
</div>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScriptFile($baseUrl.'/static/js/vimeo/froogaloop.min.js')    
    ->registerScriptFile($baseUrl.'/static/js/vimeo.js')
    ->registerScript(__FILE__,"

    window.introVideo='".$first_video['model']->video_url."';
    init(window.introVideo);
    //window.introVideo='2woH10c8l_0';
    //Pw-l4FPscEM
    
    function afterFormValidateFunction(form, data, hasError) {
        var curid=$('.current').find('input:first').attr('id');
        console.log('current: ' + $('.current'));
        form.find('.controls')
          .removeClass('error');
        
        console.log(print_r(data));
        
        if( data[curid] === undefined ) {
            console.log('validated 1');
            btn=$('.current');
            console.log(btn);
            loadVideo(btn);
                
            form.find('.controls')
              .removeClass('current');

            console.log('curid:' + curid);  
            $('#'+curid).closest('li')
                   .hide()
                   .next()
                   .show()
                   .find('.controls')
                   .addClass('current');               
        } else {
            console.log('error 1');
        }

        if (empty(data)){
        return true;
        //        $('form#registration').submit();
//            $.post(form.attr('action'), form.serialize(), function(data){
//                if (data) {
//                    alert(data);
//                }
//            });                            
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
