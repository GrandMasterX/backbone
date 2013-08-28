<?php $this->widget('bootstrap.widgets.TbExtendedTreeGridView',array(
	'id'=>'itemType-grid',
    'type' => 'striped bordered',
	'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'enablePagination'=>false,
    'bulkActionPosition'=>'top',
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'medium',
                'id' => 'unblock',
                'label' => Yii::t('itemType','Разблокировать'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#itemType-grid tr td.blocked-class").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     });

                    if(values.length > 0) {
                        $.ajax({
                             url:"'.Yii::app()->controller->createUrl('block').'",
                             data: {
                                ids:values
                             },
                             success:function(data){
                                 showMessage(data);
                                 $("#itemType-grid").yiiGridView("update");
                             }
                         });
                     }

                }'
            ),
            array(
                'buttonType' => 'button',
                'type' => 'warning',
                'size' => 'medium',
                'id' => 'block',
                'label' => Yii::t('itemType','Заблокировать'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#itemType-grid tr td.not-blocked-class").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     });

                    if(values.length > 0) {
                        $.ajax({
                             url:"'.Yii::app()->controller->createUrl('block').'",
                             data: {
                                ids:values
                             },
                             success:function(data){
                                 showMessage(data);
                                 $("#itemType-grid").yiiGridView("update");
                             }
                         });
                     }
                }'
            ),
            array(
                'buttonType' => 'button',
                'type' => 'danger',
                'size' => 'medium',
                'id' => 'remove-u-b',
                'label' => Yii::t('itemType','Удалить'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#itemType-grid").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     });

                    if(values.length > 0) {
                        $.ajax({
                             url:"'.Yii::app()->controller->createUrl('markAsDeleted').'",
                             data: {
                                ids:values
                             },
                             success:function(data){
                                 showMessage(data);
                                 $("#itemType-grid").yiiGridView("update");
                             }
                         });
                     }
                }'
            ),
        ),
        //if grid doesn't have a checkbox column type, it will attach
        //one and this configuration will be part of it
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'selectableRows'=>'2',
            'disabled'=>'$data->level==1 || $data->level==2',
            'cssClassExpression' => '($data->is_blocked > 0) ? "blocked-class" : "not-blocked-class"',
        ),
        array(
            'name'=>'item_type_search',
            'value'=>'Helper::getTranslation($data, "title")',
        ),        
		array(
			'class'=>'ButtonColumn',
			'template'=>'{update} {block} {unblock} {delete}',
			'buttons'=>array(
                'block'=>array(
                    'label'=>Yii::t('itemType', 'Выключить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите выключить этот тип изделия?')) return false;
                            $.fn.yiiGridView.update('itemType-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('itemType-grid');
                                },
                            });
                            return false;
                        }",
                ),                
                'unblock'=>array(
                    'label'=>Yii::t('itemType', 'Включить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите включить этот тип изделия?')) return false;
                            $.fn.yiiGridView.update('itemType-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('itemType-grid');  
                                },
                            });
                            return false;
                        }",
                ),
                'delete'=>array(
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('markAsDeleted',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите удалить этого пользователя?')) return false;
                            $.fn.yiiGridView.update('itemType-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('itemType-grid');  
                                },
                            });
                            return false;
                        }",
                ),                                                
			),
		),
	),
    'template'=>"{summary}{items}",
    'cssFile'=>false,   
)); ?>
 
