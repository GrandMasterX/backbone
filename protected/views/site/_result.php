<?php
$this->pageTitle=Yii::t('about', 'Результат подбора');

$this->breadcrumbs=array(
    $this->pageTitle,
);

$app=Yii::app();
$baseUrl=$app->baseUrl;
?>
<div class="inner-container result-page">
    <div class="row">
      <div class="span10 title res-holder">
        <!--<p><?php //echo $item[0]['title']; ?></p>-->
        <div class="row img-row">
          <div class="span4">
            <img id="" class="img-polaroid" src="<?php echo Yii::app()->baseUrl . DIRECTORY_SEPARATOR . Item::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR . 
                $item[0]['id'] . DIRECTORY_SEPARATOR . $item[0]['image']; ?>" alt="" width="250" height="450">      
          </div>
          <div class="span6 fitSize">
            <div class="f-s-wrapper">
<!--                <div style="float:right; margin-right:10px">
                    <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FAstra-Fit%2F461825663894545&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>                
                </div>-->
                <div style="float:left; margin-right:10px"><?php echo Yii::t('resultPage', 'Вам подходит размер: ');?></div>
                <div class="fitting-size-holder"></div> 
                <div class="" style="float:right"><?php echo CHtml::link(Yii::t('result', 'Вернуться в магазин'), 'http://musthave.ua/search?search='.$item[0]['code'], array('class'=>'return-link')); ?></div> 
                <div class="clear"></div> 
                
            </div>
            <div id="loader" class="loading-element loading-e-result"></div>    
            <div id="column-f" class="f-holder" style="display:none">
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?php 
$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScript(__FILE__,"
    
    window.fdata=new Array();
    window.sizeListArray=new Array();
    
    ".
         CHtml::ajax(array(
            'url'=>CController::createUrl('site/loadDataForResultFormulas',array()),
            'data'=>array(
                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 
                'item_id'=>$item[0]['id'],
                'type_id'=>$item[0]['type_id']
            ),
            'dataType'=>'json',
            'type'=>'POST',
            'success'=>"function(data){
                $('.f-holder').html(data.html);
                    $('.f-holder').promise().done(function() {
                    console.log('html loaded!');
                    mergeArrays(data.propToJs.prop);
                    window.sizeListArray=data.propToJs.size;
                    mergeArrays(data.rangeData)
                    mergeArrays(data.clientPropToJs);
                    replaceAndEvaluate();
                    evaluateAllResults();
                    console.log(print_r(fdata));
                    console.log(print_r(sizeListArray));
                    $('div#loader').remove();
                    $(this).fadeIn('fast');
                    $.rangeFormula.populateRangeTd();
                    $.rangeFormula.showPointersThatFit();
                });
            }"
         ))
    ."
    
    function mergeArrays(arr){
        $.each(arr, function(index, item) {
            window.fdata[index]=item;
        });
    }
    
    function evaluateAllResults() {
        if($('#type_id').val()!='' && $('#item_id').val()!='' && $('#client_id').val()!='') {   
            var inputs=$('div#resulting-column-f :input.fvalue');
            $.each(inputs, function(index) {
                var id = $(this).attr('class').split(' ')[0];    
                val=$(this).val();
                evaluateResult(id, val);
            });    
        }    
    }
    
    function evaluateResult(id, val) {
        $.each(window.sizeListArray, function(indexS, size) {
            newVal = '{'+size+'_'+val.substring(1);
            var sg_min = window.fdata['{СГ_min}'];
            var sg_mid = window.fdata['{СГ_mid}'];
            var fvalue = window.fdata[newVal];
            var st_min = window.fdata['{СТ_min}'];
            var st_mid = window.fdata['{СТ_mid}'];
            var st_max = window.fdata['{СТ_max}'];
            
            if (id==23 || id==25){
                if(sg_min<=fvalue && fvalue<=sg_mid && fvalue>=(sg_mid-((sg_mid-sg_min)/3)*1)){
                    $('div#res_'+size+'_'+id).html('Тесно');
                } else if(sg_min<=fvalue && fvalue<=sg_mid && fvalue>=(sg_mid-((sg_mid-sg_min)/3)*2)) {
                    $('div#res_'+size+'_'+id).html('Комфортно');
                } else if(sg_min<=fvalue && fvalue<=sg_mid && fvalue>=(sg_mid-((sg_mid-sg_min)/3)*3)) {
                    $('div#res_'+size+'_'+id).html('Свободно');                                  
                } else {
                    $('div#res_'+size+'_'+id).html(0);
                }
            }
            if (id==24){
                if(st_min<=fvalue && fvalue<=st_max && fvalue>0){
                    $('div#res_'+size+'_'+id).html('Облегающе');
                } else if(st_min<=fvalue && fvalue<=st_max && fvalue>=(st_mid-((st_mid-st_min)/3)*1)) {
                    $('div#res_'+size+'_'+id).html('Комфортно');
                } else if(st_min<=fvalue && fvalue<=st_max && fvalue>=(st_mid-((st_mid-st_min)/3)*2)) {
                    $('div#res_'+size+'_'+id).html('Комфортно');                                  
                } else if(st_min<=fvalue && fvalue<=st_max && fvalue>=(st_mid-((st_mid-st_min)/3)*3)) {
                    $('div#res_'+size+'_'+id).html('Свободно');
                }             
            }
            
        });     
    }
    
    function replaceAndEvaluate(){
        var inputs=$('div#column-f :input.formula_value');
        $.each(inputs, function(index) {
            var id = $(this).attr('class').split(' ')[0];    
            str=$(this).val();
            substitute(id, str);
            evaluate(id);
        }); 
    }
    
    function substitute(id, str) {
        regexp = /\{([^}]+)\}/g;
        result = str.match(regexp);
        newVal=str;
        if(result != null) {
            $.each(result, function(index, item) {
                search=result[index];    
                $.each(window.sizeListArray, function(indexS, size) {
                if (index>=1) {
                    str = newVal;
                    str=$('div#'+size+'_'+id).html();
                }                    
                    if(str) {
                        newVal = str.replace(search,function(search) {
                            if(search in window.fdata) {
                                return window.fdata[search];
                            } else {
                                var ind='{'+size+'_'+search.substring(1);
                                return window.fdata[ind];
                            }
                        });
                    }
                    $('div#'+size+'_'+id).html(newVal);
                    });
            });
        } else {
            $.each(window.sizeListArray, function(indexS, size) {
                $('div#'+size+'_'+id).html(str);
            });
        }
        $('span#vis_'+id).html(newVal);
    }
    
    function evaluate(id) {
        $.each(window.sizeListArray, function(indexS, size) {
            var val = $('div#'+size+'_'+id).html();
            $('div#res_'+size+'_'+id).html(eval(val));
            var tag = $('form#formula-form_'+id+' input.formula_tag').val();
            window.fdata['{'+size+'_'+tag.substring(1)]=eval(val);
        });
    }                         

    
    ", CClientScript::POS_READY
); 
?>