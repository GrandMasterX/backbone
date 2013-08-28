<?php $this->widget('GridView',array(
	'id'=>'item-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$filtersForm,
//    'enableSorting' => false,
	'columns'=>array(
//        array(
//            'name'=>'image',
//            'type' => 'raw',
//            'value'=>'(!empty($data[\'mainItemImage\']))? "" : Helper::getLabel()',
//            'htmlOptions'=>array('width'=>'60px'),
//            'filter'=>false,
//        ),
        array(
            'header'=>Yii::t('item','Код'),
            'name'=>'code',
            'value'=>'$data["code"]',
            'htmlOptions'=>array('width'=>'100px'),
        ),
        'parent_id',
        array(
            'header'=>Yii::t('item', 'Наименование'),
            'name'=>'title',
            'type' => 'raw',
            'value'=>'Helper::getTranslationWithTwoLabelsNoObj($data, "title", ($data[\'ready\']==1)?true:false,($data[\'unavailable\']==1)?true:false)',
            'htmlOptions'=>array('width'=>'600px'),
            'filter'=>false,
        ),
		array(
            'header'=>Yii::t('item','Владелец'),
            'name'=>'partner',
            'value'=>'(!empty($data[\'partner\'])) ? $data[\'partner\'] : Yii::t("item", "Нет владельца")',
            'filter'=>false,
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'header'=>Yii::t('item','Тип'),
            'name'=>'type',
            'value'=>'(!empty($data[\'type\'])) ? $data[\'type\'] : Yii::t("item", "Нет типа")',
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'header'=>Yii::t('item', 'Все размеры указаны'),
            'name'=>'size_finished',
            'value'=>'(!empty($data[\'size_finished\'])) ? Yii::t("item","Да") : "-"',
            'filter'=>false,
            'htmlOptions'=>array('width'=>'100px'),
        ),
//        array(
//            'name'=>'sizeTitleList',
//            'filter' =>ItemSize::toArray(),
//            'htmlOptions'=>array('width'=>'100px'),
//        ),
        array(
            'header'=>Yii::t('item','Цена'),
            'name'=>'price',
            'value'=>'$data[\'price\']',
            'htmlOptions'=>array('width'=>'100px'),
            'filter'=>false,
        ),
//        array(
//            'name'=>'desc',
//            'value'=>'Helper::getTranslation($data, "desc")',
//            'filter'=>false,
//        ),
		array(
			'class'=>'ButtonColumn',
			'template'=>'{copy} {update} {block} {unblock} {delete}',
			'buttons'=>array(
                'copy'=>array(
                    'label'=>Yii::t('item', 'Скопировать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_copy.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('copy',array('id'=>$data['id']));
                    },
                    'click'=>"
                        function() {
                            if(!confirm('Скопировать?')) return false;
                        }",
                ),
                'update'=>array(
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('update',array('id'=>$data['id']));
                    },
                ),
                'block'=>array(
                    'label'=>Yii::t('item', 'Выключить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data['id']));
                    },
                    'visible'=>'$data[\'is_blocked\'] < 1 && $data[\'is_locked\'] <> 1',
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
                        return Yii::app()->controller->createUrl('block',array('id'=>$data['id']));
                    },
                    'visible'=>'$data[\'is_blocked\'] > 0 && $data[\'is_locked\'] <> 1',
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
                        return Yii::app()->controller->createUrl('markAsDeleted',array('id'=>$data['id']));
                    },
                    'visible'=>'$data[\'is_locked\'] <> 1',
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