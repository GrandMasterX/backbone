<?php if($evResult['status']['result']==1): ?>
<!--modal-->
    <?php $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id'=>'looseortight',
        'autoOpen'=>($evResult['status']['fitF']==2 || $evResult['status']['fitF']==4) ? true : false,
        'htmlOptions'=>array('data-keyboard'=>false, 'data-backdrop'=>'static'),
    )); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('result', 'Ваши предпочтения'); ?></h4>
    </div>
     
    <div class="modal-body">
          <h3 style="text-align:center"><?php echo Yii::t('result', '
            Вы предпочитаете носить одежду более:
          ');?>
          </h3>
    </div>
        <div style="text-align:center; margin-bottom:20px">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'primary',
                'label'=>Yii::t('result', 'Плотно'),
                'url'=>'#',
                'htmlOptions'=>array('data-dismiss'=>'modal', 'class'=>'btn-large', 'id'=>'idealSizeTight'),
            )); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'primary',
                'label'=>Yii::t('result', 'Свободно'),
                'url'=>'#',
                'htmlOptions'=>array('data-dismiss'=>'modal', 'class'=>'btn-large', 'id'=>'idealSizeBaggy'),
            )); ?>
        </div>            
     
    <div class="modal-footer">
    </div>
    <?php $this->endWidget(); ?>
<!--modal end-->
<?php endIf;?>  
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
                $item[0]['id'] . DIRECTORY_SEPARATOR . $item[0]['thumbnail']; ?>" alt="" width="200" height="300"><!--250/450-->      
          </div>
          <div class="span6 fitSize">
            <div class="f-s-wrapper">
                <div style="float:left; margin-right:10px">
                    <?php if($evResult['status']['result']==1): ?>  
                        <div class="size-data-left">
                            <?php echo Yii::t('resultPage', 'Вам идеально подходит: ');?> 
                        </div>
                        <div class="size-data-left">
                            <span class="fitting-size-holder"></span>
                        </div>
                        <div class="clear"></div>  
                        
                        <?php if($evResult['status']['fitF']>1): ?>  
                            <div class="size-data-left">
                                <?php echo Yii::t('resultPage', 'Также подойдет: ');?>
                            </div>
                            <div class="size-data-left">
                                <span class="semi-fitting-size-holder" style="float:left"></span>
                            </div>
                            <div class="clear"></div>
                        <?php endIf;?>
                        
                        <div class="size-data-left">
                            <?php echo Yii::t('resultPage', 'Неподходящие размеры: ');?>
                        </div>
                        <div class="size-data-left">
                            <span class="not-fitting-size-holder" style="float:left"><?php echo CHtml::link(Yii::t('result', 'Показать'), '#',array('class'=>'do-not-fit')); ?></span>
                        </div>
                        <div class="clear"></div>                            
                    <?php endIF; ?>
                </div>
                <div class="" style="float:right"><?php echo CHtml::link(Yii::t('result', 'Вернуться в магазин'), 'http://musthave.ua/search?search='.$item[0]['code'], array('class'=>'return-link')); ?></div> 
                <div class="clear"></div> 
                
                <?php if($evResult['status']['result']!=1): ?>
                <div class="noSizeFitting">
                    <p class="text-error" style="text-align:center"><?php echo Yii::t('result', 'К сожалению, в данном изделии ни один из размеров вам не подошел.');?></p>
                    <p class="text-info" style="text-align:center"><?php echo Yii::t('result', 
                        'Предлагаем Вам воспользоваться нашим сервисом поиска изделий с подходящими вам размерами в данной категории на сайте: ') . $item[0]['www'];
                        ?>
                        </p>
                        <div class="btn-h" style="text-align:center;">
                        <?php echo CHtml::link(CHtml::encode(Yii::t('indexMain','Подобрать другие изделия по размеру')),Yii::app()->controller->createUrl('suitableItems',array('parent_id'=>$item[0]['parent_id'])),array('class'=>'btn btn-large btn-success','title'=>Yii::t('result', 'Искать'))); ?>
                        </div>
                </div>
                <?php endIf;?>                
                
            <!--<div id="loader" class="loading-element loading-e-result"></div>-->
            <div class="f-holder" style="display:none">
                <?php foreach($rangef as $rformula):?>
                    <?php $this->renderPartial('res_formula_html',array('data'=>$rformula));?>
                <?php endForeach;?>
            </div><!--f-holder-->                
            </div><!--f-s-wrapper-->
          </div>
        </div>
      </div>
    </div>
</div>

<?php 
$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    //->registerScriptFile($baseUrl.'/static/js/evaluation.js')
    ->registerScript(__FILE__,"
     window.evaluation = ".$evaluation.";
    (function() {
        var pointers = {
            config: {
               cellSize_very_tight: 147,
               cellSize_recomended: 292,
               cellSize_baggy: 147,
               very_tight: 133,
               recomended: 425,
               baggy: 572
            },         

            init: function() {
                this.evaluate();            
            },
            
            evaluate: function() {
                console.log(print_r(window.evaluation));
                var semiRecomended = new Array();
                this.attachIdealSize();
                $('div.f-holder').fadeIn('slow');
                
                for(var index in window.evaluation['evaluation']) {
                    for(var className in window.evaluation['evaluation'][index]['data']) {
                        for(var size in window.evaluation['evaluation'][index]['data'][className]) {
                            var wrapper=$('.size_wrapper_'+window.evaluation['evaluation'][index]['rangeId']);
                            if(wrapper!=undefined) {
                                var range=window.evaluation['evaluation'][index]['rangeProperties'];
                                
                                //remove after debug
                                //wrapper.find('.td-range.minus-m').addClass(index).html(range[index+'_min']).css('visibility','visible');
                                //wrapper.find('.td-range.minus').addClass(index).html(range[index+'_minr']).css('visibility','visible');
                                //wrapper.find('.td-range.plus').addClass(index).html(range[index+'_maxr']).css('visibility','visible');
                                //wrapper.find('.td-range.plus-m').addClass(index).html(range[index+'_max']).css('visibility','visible');
                                //remove aftre debug END

                                 var classNameD=className;
                                 
                                 //if no size fiiting we have to show all size that do not fit
                                 if(window.evaluation['status']['result']!=1) {
                                    classNameD=classNameD+ ' forceShow';
                                 }
                                 
                                 if(className=='recomended') {
                                    if(window.evaluation['status']['idealSize'] != size) {
                                        classNameD=classNameD+' semi_recomended';
                                        var subSize=size.toString().substring(0,2);
                                        if(!inArray(semiRecomended,subSize)) {
                                            semiRecomended[subSize]=subSize;
                                            $('.semi-fitting-size-holder')
                                                .append(this.createPointer(size,'semi-recomended',window.evaluation['evaluation'][index]['data'][className][size]))
                                                .find('a#pointer_'+size)
                                                .fadeIn('slow');
                                        }
                                    }    
                                }

                                wrapper
                                    .append(this.createPointer(size,classNameD,window.evaluation['evaluation'][index]['data'][className][size]))
                                    .find('a#pointer_'+size)
                                    .css('left',this.calculatePointerPosition(index,size,className,window.evaluation['evaluation'][index]['data'][className][size]))
                                    .end()
                                    .find('a#pointer_'+size + '.recomended')
                                    //.find('a#pointer_'+size + '.recomended:not(\'.semi_recomended\')')
                                    .fadeIn('slow');
                            }
                        }    
                    }    
                }              
            },            

            createPointer: function(size,className,value) {
                return '<a id=\"pointer_'+size+'\" href=\"#\" class=\"f-pointer '+className+'\" style=\"z-index:'+size+'\" title=\"'+value+'\"><span class=\"sizeTitle '+size+'\">'+size.toString().substring(0,2)+'</span></a>';
            },
            
            attachIdealSize: function() {
                 var size=window.evaluation['status']['idealSize'];
                 if(window.evaluation['status']['even']) {
                    $('.fitting-size-holder')
                        .html(this.createPointer(size,'recomended best',size))
                        .find('a#pointer_'+size)
                        .fadeIn('slow'); 
                 } else {
                    $('.fitting-size-holder')
                        .html(this.createPointer(size,'recomended best',size))
                        .find('a#pointer_'+size)
                        .fadeIn('slow'); 
                 }             
            },

            calculatePointerPosition : function(index,size,className,value) {
                if(className=='semi_recomended' || className=='baggy' || className=='not_fitted' 
                    || className=='recomended' || className=='very_tight') {
                
                    if(className=='semi_recomended' || className=='not_fitted')
                        className='recomended';
                  
                    var rangeProp=window.evaluation['evaluation'][index]['rangePropertiesSum'][className];
                    var min=rangeProp['min'];
                    
                    if(Math.abs(value)>Math.abs(rangeProp['sum'])) { 
                        var rangeLine=Math.abs(parseInt(pointers.config['cellSize_'+className])/Math.abs(rangeProp['sum']));
                        var valueDif=Math.abs(value)-Math.abs(min);
                        
                        if(value>=0) { 
                            var initCss=pointers.config[className];
                        }
                        else {
                            var initCss=pointers.config[className];
                        }
                        
                        var test=rangeLine*Math.abs(valueDif);
                        var css=initCss+(rangeLine*Math.abs(valueDif));
                        
                        if(value>=0) {     
                            var css=initCss-(rangeLine*Math.abs(valueDif));                        
                        } else {
                            var css=initCss-(rangeLine*Math.abs(valueDif));                        
                        }
                        return css;
                    }
                    
                    if(min<0) {
                        var zero=pointers.config[className]-((parseInt(pointers.config['cellSize_'+className])/Math.abs(rangeProp['sum']))*rangeProp['difference']);  
                        
                        if(value<0 && rangeProp['difference'] > 0) { 
                            var css=Math.round(zero+((pointers.config['cellSize_'+className]/parseInt(Math.abs(rangeProp['sum'])))*Math.abs(value)));
                        } 
                        else if(value<0 && rangeProp['difference'] == 0) { 
                            var zero=pointers.config[className]-pointers.config['cellSize_'+className];
                            var css=Math.round(zero+((pointers.config['cellSize_'+className]/parseInt(Math.abs(rangeProp['sum'])))*Math.abs(value)-Math.abs(min)));
                        }
                        else {
                            var css=Math.round(zero-((pointers.config['cellSize_'+className]/parseInt(Math.abs(rangeProp['sum'])))*Math.abs(value)));
                        }                 
                        return css;
                    } else if(min>0) {
                        if(rangeProp['difference'] > 0) {
                            var zero=pointers.config[className]+((parseInt(pointers.config['cellSize_'+className])/Math.abs(rangeProp['sum']))*rangeProp['difference']);  
                        } else {    
                            var zero=pointers.config[className];
                        }
                        var css=Math.round(zero-((pointers.config['cellSize_'+className]/parseInt(Math.abs(rangeProp['sum'])))*Math.abs(value)));
                        return css;
                    } else {
                        var zero=pointers.config[className];
                        var css=Math.round(zero-((pointers.config['cellSize_'+className]/parseInt(Math.abs(rangeProp['sum'])))*Math.abs(value)));
                        return css;
                    }
               } 
               return null; 
            }
        };
        
        if(!window.evaluation['status']['even']) {
            pointers.init();
        }    
     
        $('a.do-not-fit, a.do-not-fit-hide').on('click',function(){
            $('div.f-holder').find('.baggy').add('.baggy_plus, .very_tight, .not_fitted, .very_tight_plus, .semi_recomended:not(\'.recomended\')').fadeToggle('slow');
            $(this).toggleClass('do-not-fit-hide do-not-fit')
                .text($(this).hasClass('do-not-fit') ? '" . Yii::t('result','Показать') . "' : '" . Yii::t('result','Скрыть') . "')
                .attr('title', $(this).hasClass('do-not-fit') ? '" . Yii::t('result','Показать') . "' : '" . Yii::t('result','Скрыть') . "');
            return false;
        });
        
        $('#looseortight a').on('click',function() {
            window.evaluation['status']['idealSize']=window.evaluation['status'][$(this).attr('id')];
            pointers.init();
        });     
        
    })();     

    ", CClientScript::POS_READY
); 
?>