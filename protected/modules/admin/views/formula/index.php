<?php
$this->pageTitle = Yii::t('client', 'Управление Формулами');

$this->breadcrumbs = array(
    $this->pageTitle,
);
?>

<!-- Modal -->
<div id="copy-to-model" class="modal hide" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo Yii::t('formula', 'Копирование цепочки в модель') ?></h3>
    </div>
    <div id="copy-to-model-cont" class="modal-body" style="min-height:300px">
        <div id='c_load' class="ajax-loader"><img src="<?php echo Yii::app()->baseUrl ?>/static/img/ajax-loader.gif" /></div>
        <div class="select-holder-model">
            <?php echo Chosen::dropDownList('type-id-modal', '', array('empty' => Yii::t('formula', 'Необходимо выбрать модель'))); ?>
        </div>
        <div class="copy-result text-info well well-small" style="display:none"></div>        
    </div>
    <div class="modal-footer">
        <?php
        echo CHtml::ajaxSubmitButton(Yii::t('formula', 'Скопировать'), Yii::app()->controller->createUrl('moveChainToModel', array()), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'type_id' => 'js: $(\'#type-id-modal\').val()', 'chains' => 'js: window.chain_to_parent'),
            'success' => 'function(data){
                        $(".copy-result").show().html(data);
                    }',
                ), array(
            'type' => 'submit',
            'class' => 'btn btn-success'
        ));
        ?>

        <?php echo CHtml::button(Yii::t('formula', 'Закрыть'), array('class' => 'btn', 'data-dismiss' => 'modal')); ?>
    </div>
</div>
<!-- Modal END -->  

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>
<div class="form-horizontal formula-container">
    <fieldset>
        <legend><span class="left-margin"><?php echo Yii::t('formula', 'Исходные данные') ?><div class="test-plugin"></div></legend>
        <div id="data-select">
            <span class="formula-select-holder">
                <?php echo Chosen::dropDownList('type_id', '', ItemType::getListOfItemType(), array('empty' => Yii::t('formula', 'Выберите модель'))); ?> 
            </span>
            <span class="formula-select-holder">
                <?php echo Chosen::dropDownList('item_id', '', Chtml::listData(ItemTranslation::model()->byLanguage()->findAll(), 'id','title'), array('empty' => Yii::t('formula', 'Необходимо выбрать модель'))); ?>
            </span>

            <?php
                $this->widget('bootstrap.widgets.TbButton',array(
                    //'label' => Yii::t('formula', 'Обновить'),
                    'type' => 'primary',
                    'buttonType'=>'button',
                    'icon' => 'icon-refresh icon-white',
                    'htmlOptions'=>array(
                        'id'=>'refresh-btn',
                        'class'=>'refresh',
                        'title'=>Yii::t('formula', 'Сбросить список изделий'),
                        'style'=>'margin-right: 10px',
                    ),
                ));
            ?>

            <span class="formula-select-holder">
                <?php echo Chosen::dropDownList('client_id', '', Chtml::listData(User::model()->notBlocked()->isClient()->findAll(), 'id', 'name'), array('empty' => Yii::t('formula', 'Выберите клиента'))); ?> 
            </span>            
                <?php
                echo CHtml::ajaxSubmitButton(Yii::t('formula', 'Создать формулу'), Yii::app()->controller->createUrl('createFormula'), array(
                    'dataType' => 'json',
                    'type' => 'POST',
                    'data' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                        'type_id' => 'js: $("#type_id").val()',
                        'item_id' => 'js: $("#item_id").val()',
                        'parent_id' => 'js: $("div#column-p.active").closest("div.portlet-f").find("form:first").attr("class")',
                    ),
                    'success' => 'function(data){
                                $(".no-formula").remove();
                                if($("div#column-p.active").size()) {
                                    $("div#column-p.active").append(data);
                                } else {
                                    $("#column-f").append(data);
                                }
                                activateSortable();
                                controlCh();
                            }',
                        ), array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary disabled',
                    'id' => 'createFormula',
                    'disabled' => 'disabled',
                    'title' => Yii::t('formula', 'Создать формулу'),
                ));
                ?>

            <div class="btn-group">
                <a id="createResFormulaBtn" class="btn btn-info dropdown-toggle disabled" data-toggle="dropdown" href="#" title="<?php echo Yii::t('formula', 'Создать оценочную формулу'); ?>">
                    <i class="my-icon-formula-res-white"></i>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="range_f res-f-a use" href="#"><?php echo Yii::t('formula', 'Диапазонная'); ?></a></li>
                    <li><a class="graph_f res-f-a inactive" href="javascript:void(0)"><?php echo Yii::t('formula', 'Графическая'); ?></a></li>
                </ul>
            </div>

            <div class="btn-group">
                <a id="createParentFormulaBtn" class="btn btn-info dropdown-toggle disabled" data-toggle="dropdown" href="#" title="<?php echo Yii::t('formula', 'Цепочки'); ?>">
                    <i class="icon-folder-close icon-white"></i>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu parent-listing">
                </ul>
            </div>            

        </div>
        <fieldset>    

            <div id="layout-container">
                <div class="pane ui-layout-center">
                    <div id="column-f" class="column-f">
                    </div>
                </div>
                <div class="pane ui-layout-east">
                    <div id="column" class="column">
                        <div class="portlet">
                            <div class="portlet-header"><?php echo Yii::t('formula', 'Свойства изделия'); ?></div>
                            <div class="portlet-content"><span id="item-property"><?php $this->renderPartial('_itemProperty'); ?></span></div>
                        </div>

                        <div class="portlet">
                            <div class="portlet-header"><?php echo Yii::t('formula', 'Свойства пользователя'); ?></div>
                            <div class="portlet-content"><span id="client-property"><?php $this->renderPartial('_clientProperty'); ?></span></div>
                        </div>

                        <div class="portlet">
                            <div class="portlet-header"><?php echo Yii::t('formula', 'Диапазоны модели'); ?></div>
                            <div class="portlet-content"><span id="range-property"><?php $this->renderPartial('application.modules.admin.views.itemType._rangeList'); ?></span></div>
                        </div>              
                    </div>        
                </div>
            </div>
            </div>

<?php
$app = Yii::app();
$baseUrl = $app->baseUrl;

$app->clientScript
        ->registerCoreScript('jquery')
        ->registerCoreScript('jquery.ui')
        ->registerCssFile($baseUrl . '/static/admin/layout/css/layout-default-latest.css')
        ->registerScriptFile($baseUrl . '/static/admin/debug/print_r.js')
        ->registerScriptFile($baseUrl . '/static/js/garand-sticky/jquery.sticky.js')
        ->registerScriptFile($baseUrl . '/static/admin/layout/js/jquery.layout-latest.min.js')
        ->registerScriptFile($baseUrl . '/static/admin/js/portlets.js')
        ->registerScriptFile($baseUrl . '/static/admin/js/main.js')
        ->registerScript(__FILE__, "
  
    window.fdata=new Array();
    window.sizeListArray=new Array();
    window.f_to_parent=new Array();
    window.chain_to_parent=new Array();
    window.bluredInput='';
    window.typeId=0;
    window.itemId=0;
    window.typeText='';
    window.itemText='';
    window.thisisnewvalue = 0;
    
    $('#layout-container').layout({
            resizable:false,
            east: { size: 214},
        });
        
    $('#data-select').sticky({topSpacing:0});
    $('#column').sticky({topSpacing:0});
    
    $('input#Formula_title').live('click',function(){
        if(this.value == this.defaultValue){
            this.select();
        }            
    });
    
    $('div#range-wrapper :input').live('click',function(){
        if(this.value == this.defaultValue){
            this.select();
        }            
    });              
    
    $('#type_id').change(function() {
        if($('#type_id').val()=='') {
            clearFieldsAndLists();
        } else {
        " .
                    CHtml::ajax(array(
                        'url' => CController::createUrl('itemType/loadFormulaList', array()),
                        'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'type_id' => 'js: $(this).val()'),
                        'dataType' => 'json',
                        'type' => 'POST',
                        'success' => "function(data){
                            checkIfSelected();
                            $('#column-f').html(data);
                            activateSortable();
                            replaceAndEvaluate();
                            evaluateAllResults();
                            controlCh();
                        }"
                    ))
                    . "

        var url='" . CController::createUrl('item/getListOfItemsWithTranslationByItemTypeId?type_id=') . "';
        $('#item_id').load(url + $(this).val(), function(){
            $('#item_id').trigger('liszt:updated');
        });

        loadParentFormulas($(this).val());

        " .
                    CHtml::ajax(array(
                        'url' => CController::createUrl('itemType/loadRange', array()),
                        'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'type_id' => 'js: $(this).val()'),
                        'dataType' => 'json',
                        'type' => 'POST',
                        'success' => "function(data){
                    $('span#range-property').html(data.html);
                    mergeArrays(data.dataToJs);
                    evaluateAllResults();
                    $.rangeFormula.populateRangeTd();
                }"
                    ))
                    . "    
        }
    });
$('#item_id').change(function() {
    if($('#type_id').val() == '' || $('#type_id').val() == '0') {
        " .
                CHtml::ajax(array(
                    'async' => false,
                    'url' => CController::createUrl('itemType/loadFormulaList', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'item_id' => 'js: $(this).val()'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                    checkIfSelected();
                    window.typeText = findOptionTextByType(data.type_id);
                    window.itemText = findOptionTextByItem(data.item_id);
                    $('#column-f').html(data.html);
                    window.itemId = data.item_id;
                    window.typeId = data.type_id;
                    window.thisisnewvalue = data.type_id;
                    activateSortable();
                    replaceAndEvaluate();
                    evaluateAllResults();
                    controlCh();
                    $('span#item-property').html(data.html);
                    if(data.propToJs) {
                        mergeArrays(data.propToJs.prop);
                        window.sizeListArray=data.propToJs.size;
                    }
                    $.rangeFormula.populateRangeTd();
               }"
                ))
                . "
            var url='" . CController::createUrl('item/getListOfItemsWithTranslationByItemTypeId?type_id=') . "';
            $('#item_id').load(url + window.typeId, function(){
                $('#item_id').trigger('liszt:updated');
            });
            
            loadParentFormulas(window.typeId);
            
       " .
                CHtml::ajax(array(
                    'url' => CController::createUrl('item/loadSizeList', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'item_id' => 'js: window.itemId'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                checkIfSelected();
                $('span#item-property').html(data.html);
//                if(data.propToJs.length>0) {
                    mergeArrays(data.propToJs.prop);
                    window.sizeListArray=data.propToJs.size;
//                }
                replaceAndEvaluate();
                evaluateAllResults();
                controlCh();
                $.rangeFormula.populateRangeTd();
            }"
                ))
                . "
       " .
                CHtml::ajax(array(
                    'url' => CController::createUrl('itemType/loadRange', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'type_id' => 'js: window.typeId'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                    $('span#range-property').html(data.html);
                    mergeArrays(data.dataToJs);
                    evaluateAllResults();
                    $.rangeFormula.populateRangeTd();
                    setDroppedValues();
                }"
                ))
                . "
    } else {
        " .
                CHtml::ajax(array(
                    'url' => CController::createUrl('item/loadSizeList', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'item_id' => 'js: $(this).val()'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                checkIfSelected();
                $('span#item-property').html(data.html);
//                if(data.propToJs.length>0) {
                    mergeArrays(data.propToJs.prop);
                    window.sizeListArray=data.propToJs.size;
//                }
                replaceAndEvaluate();
                evaluateAllResults();
                controlCh();
                $.rangeFormula.populateRangeTd();
            }"
                ))
                . "
    " .
                CHtml::ajax(array(
                    'url' => CController::createUrl('itemType/loadFormulaList', array()),
                    'data' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                        'item_id' => 'js: $(this).val()',
                        'type_id' => 'js: $("#type_id").val()',
                    ),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                checkIfSelected();
                $('#column-f').html(data.html);
                $.rangeFormula.populateRangeTd();                    
            }"
                ))
                . "
    }
});
    $('#client_id').change(function() {" .
                CHtml::ajax(array(
                    'url' => CController::createUrl('client/loadSizeList', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'client_id' => 'js: $(this).val()'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                checkIfSelected();
                $('span#client-property').html(data.html);
                mergeArrays(data.clientPropToJs);
                replaceAndEvaluate();
                evaluateAllResults();
                $.rangeFormula.populateRangeTd();
            }"
                ))
                . "});
    
    function findOptionTextByType(curr_value){
        var options = $('#type_id option');
        var values = $.map(options ,function(option) {
            if((option.value == curr_value)) {
                return option.text;
            }
        });
        return values;
    }
    
    function clearFieldsAndLists() {
        var url='" . CController::createUrl('item/getListOfItemsWithTranslationByItemTypeId?type_id=') . "';
        $('#item_id').load(url + window.typeId, function(){
            $('#item_id').trigger('liszt:updated');
        });
        $('#column-f').html('');
        $('span#range-property').html('<span id=".'range-info'.">Нет диапазонов</span>');
        $('span#item-property').html('<span id=".'item-property-info'.">Необходимо выбрать изделие</span>');
        $('span#client-property').html('<span id=".'client-property-info'.">Необходимо выбрать клиента</span>');
    }
    
    function setDroppedValues(){
        $('#type_id').val(window.typeId);
        $('#item_id').val(window.itemId);
        $('.formula-select-holder:eq(0)').find('#type_id_chzn').find('span').html(window.typeText);
        $('.formula-select-holder:eq(1)').find('#item_id_chzn').find('span').html(window.itemText);
    }
    
    function findOptionTextByItem(curr_value){
        var options = $('#item_id option');
        var values = $.map(options ,function(option) {
            if((option.value == curr_value)) {
                return option.text;
            }
        });
        return values;
    }
    function mergeArrays(arr){
        $.each(arr, function(index, item) {
            window.fdata[index]=item;
        });
//        console.log(print_r(window.fdata));
//        console.log('window.sizeListArray' + print_r(window.sizeListArray));
    }
    
    function loadParentFormulas(val) {
        var url='" . CController::createUrl('formula/GetListOfParentFormulasByTypeId?type_id=') . "';
        $('.parent-listing').load(url + val, function(){
        });         
    }    
    
    $('select.titleSelect').live('change',function() {
        var id = $(this).attr('class').split(' ')[0];
        var inputId=$(this).attr('id');
        autoSave(id,inputId);
        $.rangeFormula.populateRangeTd();
    });     
    
    $('span.size-abr-holder a').live('click', function(){
        var val=$('div#formula_'+bluredInput+' input#Formula_value').val();
        var newVal=val+$(this).text();
        $('div#formula_'+bluredInput+' input#Formula_value').val(newVal)
        substitute(bluredInput, newVal);
        return false;
    });
    
    function checkIfSelected(){
        if($('#type_id').val()!='' && $('#item_id').val()!='') {
            $('#createFormula').removeClass('disabled').removeAttr('disabled', 'disabled');
            $('#createResFormulaBtn').removeClass('disabled');
        } else {
            $('#createFormula').addClass('disabled').attr('disabled', 'disabled');
            $('#createResFormulaBtn').addClass('disabled');        
        }   
    }

    function selectIsSelected(id){
        return ($('#'+id).val()!='' && $('#'+id).val()!='') ? true : false;
    }
    
    function replaceAndEvaluate(){
//            console.log('replaceAndEvaluate START');
            var inputs=$('div#column-f :input.formula_value');
//            console.log(inputs.length);
            $.each(inputs, function(index) {
                var id = $(this).attr('class').split(' ')[0];    
                str=$(this).val();
                substitute(id, str);
                evaluate(id);
//                console.log('replaceAndEvaluate START: ' + index);
            });
//            console.log('replaceAndEvaluate END');
    }
    
    $('input.formula_value').live('click keyup', function() {
        var id = $(this).attr('class').split(' ')[0];
        str=$(this).val();
        substitute(id, str);
        bluredInput=id;
    });
    
    $('input.formula_value').live('blur', function() {       
        var id = $(this).attr('class').split(' ')[0];
        var inputId=$(this).attr('id');
        replaceAndEvaluate();
        autoSave(id,inputId);
    });
    
    $('input.formula_title').live('blur', function() {       
        var id = $(this).attr('class').split(' ')[0];
        var inputId=$(this).attr('id');
        autoSave(id,inputId);
    });
    
    $('a.range-edit').live('click', function() {
        " . CHtml::ajax(array(
                    'url' => CController::createUrl('itemType/loadRangeForUpdate', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'key' => 'js: $(this).attr(\'id\')', 'type_id' => 'js: $(\'#type_id\').val()'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                if(data.status=='edit') {
                    $('table#'+data.key).replaceWith(data.html);
                }
            }"
                )) . "
         return false;        
    });
    
    $('a.range-update').live('click', function() {
        var id=$(this).closest('tr').attr('id');
        formData=$('form#range_edit_'+id).serialize();
        jQuery.ajax({
            'url':'" . CController::createUrl('itemType/updateRange') . "',
            'dataType':'json',
            'type':'POST',
            'cache':false,
            'data':formData,
            'success':function(data){
                if(data.status=='success'){
                    $('table#'+data.key).replaceWith(data.html);
                    mergeArrays(data.dataToJs);
                    evaluateAllResults();
                    $.rangeFormula.populateRangeTd();
                } else
                {
                 $.each(data.error, function(key, val) {
                     $('#formula-form_'+prefixId+' #'+key+'_em_').text(val);                                                    
                     $('#formula-form_'+prefixId+' #'+key+'_em_').parent('div.controls').addClass('error');
                     $('#formula-form_'+prefixId+' #'+key+'_em_').show();
                 });
               }                    
            }
        });         
         return false;        
    });        
    
    $('input.formula_tag').live('blur', function() {       
        var id = $(this).attr('class').split(' ')[0];
        var inputId=$(this).attr('id');
        var val=$(this).val();
        
        if(val.charAt(0)!='{')
            val='{'+val;
            
        if(val.charAt(val.length - 1)!='}')
            val=val+'}';
        
        val=val.replace(/ /g,'-');
        $(this).val(val);
        evaluate(id);
        autoSave(id,inputId);
    });
    
    $('form[id^=formula-form_] input').live('focus', function() {       
        $(this).removeClass('saved');
    });        
    
    function substitute(id, str) {
//        console.log('substitute called');
//        console.log('str: ' + str);
        regexp = /\{([^}]+)\}/g;
        result = str.match(regexp);
//        console.log('result: ' + result);
        newVal=str;
        if(result != null) {
//           console.log('result not null');
//            console.log(print_r(result));
            $.each(result, function(index, item) {
//                console.log('result each: ' + item);
                search=result[index];
//                console.log('search: ' + search);
                $.each(window.sizeListArray, function(indexS, size) {
//                console.log('sizeListArray each: ' + indexS + ' size: ' + size);
                if (index>=1) {
                    str = newVal;
                    str=$('div#'+size+'_'+id).html();
//                    console.log('str22222: ' + str + 'for id: ' + id);
                }                    
                    if(str) {
//                        console.log('there is a string!!!!!!!!!!!!!!!!!!!');
                        newVal = str.replace(search,function(search) {
                            if(search in window.fdata) {
                                return window.fdata[search];
                            } else {
                                var ind='{'+size+'_'+search.substring(1);
                                return window.fdata[ind];
//                            console.log('newVal: ' + newVal);
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
    
    function autoSave(prefixId,inputId) {
        formData=$('#formula-form_'+prefixId).serialize();
        jQuery.ajax({
            'url':'" . CController::createUrl('formula/autoUpdate') . "',
            'dataType':'json',
            'type':'POST',
            'cache':false,
            'data':formData,
            'success':function(data){
                if(data.status=='success'){
                    if($('.'+prefixId).is('select')) {
                        $('select.'+prefixId).addClass('saved');
                    } else {
                        $('#formula-form_'+prefixId+' input#'+inputId).addClass('saved');
                        $('#formula-form_'+prefixId+' #'+inputId+'_em_').parent('div.controls').removeClass('error');
                        $('#formula-form_'+prefixId+' #'+inputId+'_em_').hide();                        
                    }
                    $('#formula-form_'+prefixId).find('.rangeTitle').val(data.rangeTitle);
                    $.rangeFormula.populateRangeTd();
                } else {
                 $.each(data.error, function(key, val) {
                     $('#formula-form_'+prefixId+' #'+key+'_em_').text(val);                                                    
                     $('#formula-form_'+prefixId+' #'+key+'_em_').parent('div.controls').addClass('error');
                     $('#formula-form_'+prefixId+' #'+key+'_em_').show();
                 });
               }                    
            }
        });     
    }
    
    $('a.f-del-a').live('click',function() {
        if(checkIfPlaceHolderUsed($(this).attr('id'))) {
            alert('" . Yii::t('formula', 'Эта формула не может быть удалена, так как ее значение используется в других формулах!') . "');
            return false;
        }
        
        if ($(this).closest('div.portlet-f').find('div#column-p').children().length > 0) {
            alert('" . Yii::t('formula', 'Эта цепочка не может быть удалена, так как у нее есть формулы!') . "');
            return false;        
        }
        
        if(!confirm('" . Yii::t('formula', 'Вы уверены что хотите удалить эту формулу?') . "')) return false;
        " . CHtml::ajax(array(
                    'url' => CController::createUrl('formula/delete', array()),
                    'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken, 'id' => 'js: $(this).attr("id")'),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                if(data.status='success') {
                    $('#formula-form_'+data.id).closest('div.portlet-f').remove();
                    loadParentFormulas($('#type_id').val());                    
                }    
                else
                    alert('data.status');
            }"
                ))
                . "
         return false;
    });

    $('a.check-detach').live('click', function(e) {
        if($(this).hasClass('inactive'))
            return false;
    });
    
    $('.f-chbox').live('click', function() {
        controlCh();
        $('a.check-copy').addClass('inactive');
        if($(this).hasClass('no-parent')){
            $('a.check-detach').removeClass('detach').addClass('inactive');
            var inputs=$('.f-chbox.no-parent:checked');
            $('.f-chbox:not(.no-parent):checked').add('.p-chbox:checked').removeAttr('checked');
        } else {
            $('a.check-detach').removeClass('inactive').addClass('detach');
            var inputs=$('.f-chbox:not(.no-parent):checked');
            $('.f-chbox.no-parent:checked').add('.p-chbox:checked').removeAttr('checked');
        }
        
        controlAttachLink();
        window.f_to_parent=new Array();
        inputs.each(function(index) {
            window.f_to_parent[index]=this.value;
        });
    });

    $('.p-chbox').live('click', function() {
        controlCh();
        $('a.check-detach').addClass('inactive');
        if($(this).is(':checked')){
            $('a.check-copy').removeClass('inactive');
            var inputs=$('.p-chbox:checked');
            $('.f-chbox:checked').removeAttr('checked');
        } else {
            $('a.check-copy').add('a.parent').addClass('inactive');
        }
        
        controlAttachLink();
        
        window.chain_to_parent=new Array();
        inputs.each(function(index) {
            window.chain_to_parent[index]=this.value;
        });
    });    
    
    function controlAttachLink() {
        if($('.p-chbox:checked').length>0)
            $('a.attach-link').removeClass('attach').addClass('inactive');
        else    
            $('a.attach-link').addClass('attach').removeClass('inactive');
    }
    
    function controlCh() {
        if($('.f-chbox:checked').length > 0 || $('.p-chbox:checked').length > 0 || selectIsSelected('type_id')) {
            $('#createParentFormulaBtn').removeClass('disabled');
        } else {
            $('#createParentFormulaBtn').addClass('disabled');
        }
    }
    
    function checkIfPlaceHolderUsed(id) {
        match=false;
        var link = $('a#'+id);
        if(link.hasClass('res-f'))
            return match;
        
        val=link.closest('form').find('input#Formula_tag').val();
        if(val){
            var inputs=$('div#column-f :input.formula_value').add('div#resulting-formula-wrapper :input.fvalue');
            $.each(inputs, function(index) {
                inputVal=$(this).val();
                var str = new RegExp(val, 'g');
                result=str.test(inputVal);
                $(this).stop().css('color','#555555');
                if(result) {
                    $(this).animate({'color':'red'}, 500, function(){
                        $(this).animate({'color':'#555555'}, 50000);
                    });
                    match=true;
                }    
            });
        }        
        return match;
    }
    
    $('a.res-f-a.use').live('click', function() {
        $(this)
            .closest('div.btn-group')
            .removeClass('open');
            
        " . CHtml::ajax(array(
                    'url' => Yii::app()->controller->createUrl('createResultFormula'),
                    'data' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                        'type' => 'js: $(this).attr(\'class\').split(\' \')[0]',
                        'type_id' => 'js: $("#type_id").val()',
                        'ch_array' => 'js: window.f_to_parent',
                        'parent_id' => 'js: $("div#column-p.active").closest("div.portlet-f").find("form:first").attr("class")',
                    ),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                $('.no-formula').remove();
                $.each(data.ch_array, function(index, item) { 
                    $('form.'+item).closest('.portlet-f').remove();
                });
                window.f_to_parent=new Array();
                
                if($('div#column-p.active').size() && data.type!=4) {
                    $('div#column-p.active').append(data.html);
                } else {
                    $('#column-f').append(data.html);
                }
                activateSortable();
                loadParentFormulas($('#type_id').val());
                controlCh();
            }"
                )) . "
         return false;        
    });
    
    $('a.attach, a.detach').live('click', function(){
        $(this)
            .closest('div.btn-group')
            .removeClass('open');

        var action=null
        if($(this).hasClass('attach'))
            var action = 'attach';

        if($(this).hasClass('detach'))
            var action = 'detach';

    " .
                CHtml::ajax(array(
                    'url' => CController::createUrl('formula/bindToParentActionOverFormula', array()),
                    'data' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                        'type_id' => 'js: $("#type_id").val()',
                        'item_id' => 'js: $("#item_id").val()',
                        'ch_array' => 'js: window.f_to_parent',
                        'parent_id' => 'js: $(this).attr("id")',
                        'action' => 'js: action',
                    ),
                    'dataType' => 'json',
                    'type' => 'POST',
                    'success' => "function(data){
                checkIfSelected();
                $('#column-f').html(data);
                activateSortable();
                replaceAndEvaluate();
                evaluateAllResults();
                controlCh();
            }"
                ))
                . "
        return false;
    });
            

    $('input.fvalue').live('blur', function() {       
        var id = $(this).attr('class').split(' ')[0];
        var inputId=$(this).attr('id');
        val = $(this).val();
        autoSave(id,inputId);
        evaluateResult(id, val);

    });
    
    $('a.open-parent-f').live('click', function() {
        $(this).addClass('current');
        $('div#column-f a.open:not(.current)').each(function( index ) {
            $(this).toggleClass('open')
                .parent('span')
                .toggleClass('open-f')
                .toggleClass('closed-f')
                .closest('div.portlet-f')
                .find('div#child-wrapper-outer')
                .toggleClass('active')
                .slideToggle();
        });        
        
        $(this).toggleClass('open')
            .removeClass('current') 
            .parent('span')
            .toggleClass('open-f')
            .toggleClass('closed-f')
            .closest('div.portlet-f')
            .find('div#child-wrapper-outer')
            .slideToggle(function(){
                    $.rangeFormula.populateRangeTd();
                })
            .find('div#column-p')
            .toggleClass('active');

            if($('div#column-p.active').size()) {
                window.activeParentId=$('div#column-p.active').closest('form').attr('class');
            } else {
                window.activeParentId=null;
            }
        return false;
    });
    
    function evaluateAllResults() {
//        console.log('evaluateAllResults');
        if($('#type_id').val()!='' && $('#item_id').val()!='' && $('#client_id').val()!='') {
            var inputs=$('div#resulting-column-f :input.fvalue');
            $.each(inputs, function(index) {
                var id = $(this).attr('class').split(' ')[0];    
                val=$(this).val();
                evaluateResult(id, val);
            });    
        } else {
//            console.log('empty');
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
    
    $('#copy-to-model').on('show', function () {
        var url='" . CController::createUrl('itemType/getListOfModels') . "';
        $('#type-id-modal').load(url, function(){
            $('#type-id-modal').trigger('liszt:updated');
            $('div#c_load').hide();
        });
    })

    $('.copy-model').live('click', function(){
        $('#type_id').val();

        " .
            CHtml::ajax(array(
                'url' => CController::createUrl('itemType/copyModel', array()),
                'data' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                    'id' => 'js: $("#type_id").val()',
                ),
                'dataType' => 'json',
                'type' => 'POST',
                'success' => "function(data){
                    $('a#createParentFormulaBtn').parent('div').removeClass('open');
                    var url='" . CController::createUrl('itemType/getListOfModels') . "';
                    $('#type_id').load(url, function(){
                        $('#type_id').trigger('liszt:updated');
                    });
                    showMessage(data.message);
                    //alert(data.message);
                }"
            ))
            . "

        return false;
    });

    $('#refresh-btn').on('click',function() {
        var url1='" . CController::createUrl('itemType/getListOfModels') . "';
        $('#type_id').load(url1, function(){
            $('#type_id').trigger('liszt:updated');
        });

        var url2='" . CController::createUrl('item/getListOfItems') . "';
        $('#item_id').load(url2, function(){
            $('#item_id').trigger('liszt:updated');
        });
    });
    
    ", CClientScript::POS_READY
);
?> 
