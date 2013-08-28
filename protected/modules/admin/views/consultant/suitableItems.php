<div id="size-holder" class="size-holder center"><?php echo Yii::t('suitableItems','Обработано изделий:') . ' <span class="processed">0</span>/' . $itemCount . ' Подошло изделий: <span class="fitting">0</span>';?></div>
<div class="span10 suitable center">
    <div class="noSizeFitting" style="display:none">
        <p class="text-error" style="text-align:center"><?php echo Yii::t('suitableItems', 'К сожалению, среди изделий выбранной категории нет подходящего вам размера.');?></p>
    </div> 
    <ul class="fitting-items">
    </ul>
   
    <div id="loader" class="loading-s"></div>
    <div class="clear"></div>
    <div class="more">
        <?php echo CHtml::submitButton(Yii::t('suitableItems', 'Показать еще'),array('class'=>'btn more-a')); ?>
    </div>
</div>

<?php 
$app=Yii::app();
$baseUrl=$app->baseUrl;
$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScriptFile($baseUrl.'/static/js/garand-sticky/jquery.sticky.js')
    ->registerScript(__FILE__,"
        window.total=" . $itemCount . ";
        window.allow_trigger = false;
        window.offset=0;
        window.fittingCount=0;
        console.log(window.offset);
        $('#size-holder').sticky({topSpacing:0,center:true,});       
        
        $('#loader').sticky({topSpacing:100,center:true,});
        
        loadData(window.offset);
        var pr=$('span.processed');
        function loadData(last_id) {
            ".CHtml::ajax(array(
                'url'=>CController::createUrl('consultant/SuitableItemsViaAjax',array()),
                'data'=>array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 
                    'parent_id'=> Yii::app()->request->getQuery('parent_id'),
                    'lastuserid'=> Yii::app()->request->getQuery('lastuserid'),
                    'offset'=>'js:window.offset'
                    ),
                'dataType'=>'json',
                'type'=>'POST',
                'beforeSend'=>"function() {
                    $('#loader').show();
                    $('.more-a').hide();
                }",
                'success'=>"function(data){
                    $('#loader').hide();
                    if(parseInt(data.fitting)==0 && $('.fitting-items').length==0) {
                        $('.noSizeFitting').show();
                    };
                    $('.fitting-items').append(data.html).find('.new').fadeIn('slow').removeClass('new');
                    
                    var proc=parseInt(pr.html())+parseInt(data.processed);
                    pr.html((proc >= window.total) ? window.total : proc);
                    var ft=$('span.fitting');
                    ft.html(parseInt(ft.html()) + parseInt(data.fitting));
                    window.fittingCount+=data.fitting;
                    
                    var left=window.total-parseInt(pr.html());
                    //console.log('window.fittingCount: ' + window.fittingCount);
                    //console.log('left: ' + left);
                    if (window.fittingCount<10 && left>=10){
                        window.offset=window.offset+10;
                        loadData(window.offset);
                        window.allow_trigger = false;                    
                        console.log('evovked');
                    } else {
                        if(left!=0) {
                            $('.more-a').fadeIn();                    
                        }
                    }

                    window.allow_trigger = true;
                }"
             ))."
         }

        $(window).scroll(function(){
            if(parseInt(pr.html()) < window.total) {
                if ($(window).scrollTop() == $(document).height() - $(window).height()){
                    if(window.allow_trigger) {
                        window.fittingCount=0;
                        window.offset=window.offset+10;
                        console.log(window.offset);
                        loadData(window.offset);
                        window.allow_trigger = false;
                    }
                }                    
            } else {
            console.log('the end');
        }
        });
        
        $('.more').on('click',function() {
            if(window.allow_trigger) {
                window.fittingCount=0;
                window.offset=window.offset+10;
                console.log(window.offset);
                loadData(window.offset);
                window.allow_trigger = false;
            }            
        });
    
        
    ", CClientScript::POS_READY
); 
?>    