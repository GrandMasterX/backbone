<?php $this->widget('GridView',array(
	'id'=>'item-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
        'enableSorting' => false,
	'columns'=>array(
        array(
            'name'=>'image',
            'type' => 'raw',
            'value'=>'($data->mainItemImage)? "" : Helper::getLabel()',
            'htmlOptions'=>array('width'=>'60px'),
            'filter'=>false,
        ),
        array(
            'name'=>'code',
            'htmlOptions'=>array('width'=>'100px'),
        ),                        
        array(
            'name'=>'title',
            'type' => 'raw',
            'value'=>'Helper::getTranslationWithTwoLabels($data, "title", ($data->ready)?true:false,($data->unavailable)?true:false)',
            'htmlOptions'=>array('width'=>'600px'),
            'filter'=>false,
        ),
		array(
            'name'=>'partner_id',
            'value'=>'($data->partner) ? $data->partner->company_title : Yii::t("item", "Нет владельца")',
            'filter'=>false,
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'name'=>'type_search',
            'value'=>'($data->type) ? Helper::getTranslation($data->type, "title") : Yii::t("item", "Нет типа")',
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'name'=>'size_finished',
            'value'=>'($data->size_finished) ? Yii::t("item","Да") : "-"',
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'name'=>'sizeTitleList',
            'filter' =>ItemSize::toArray(),
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'name'=>'price',
            'htmlOptions'=>array('width'=>'100px'),
        ),
//        array(
//            'name'=>'desc',
//            'value'=>'Helper::getTranslation($data, "desc")',
//            'filter'=>false,
//        ),
		array(
			'class'=>'ButtonColumn',
			'template'=>'{update} {block} {unblock} {delete}',
			'buttons'=>array(
                'block'=>array(
                    'label'=>Yii::t('item', 'Выключить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите выключить это изделие?')) return false;
                            $.fn.yiiGridView.update('item-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('item-grid');
                                },
                            });
                            return false;
                        }",
                ),                
                'unblock'=>array(
                    'label'=>Yii::t('item', 'Включить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите включить это изделие?')) return false;
                            $.fn.yiiGridView.update('item-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('item-grid');  
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
                            if(!confirm('Вы уверены что хотите удалить это изделие?')) return false;
                            $.fn.yiiGridView.update('item-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('item-grid');  
                                },
                            });
                            return false;
                        }",
                ),                                                
			),
		),
	),
    'template'=>"{sizer}\n{items}\n{pager}",
    'cssFile'=>false,   
    'pager'=>array(
        'class'=>'LinkPager',
        'header'=>'',
    ),        
    'sizer'=>array(
        'class'=>'ListSizer',
        'header'=>'Позиций на странице: ',
    ),    
)); ?>