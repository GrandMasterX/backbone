<?php $this->widget('GridView',array(
	'id'=>'clientSize-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
        array(
            'name'=>'title',
            'value'=>'Helper::getTranslation($data, "title")',
            'filter'=>false,
        ),
		array(
			'class'=>'ButtonColumn',
			'template'=>'{update} {block} {unblock} {delete}',
			'buttons'=>array(
                'block'=>array(
                    'label'=>Yii::t('clientSize', 'Выключить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите выключить этот размер?')) return false;
                            $.fn.yiiGridView.update('clientSize-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('clientSize-grid');
                                },
                            });
                            return false;
                        }",
                ),                
                'unblock'=>array(
                    'label'=>Yii::t('clientSize', 'Включить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите включить этот размер?')) return false;
                            $.fn.yiiGridView.update('clientSize-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('clientSize-grid');  
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
                            if(!confirm('Вы уверены что хотите удалить этот размер?')) return false;
                            $.fn.yiiGridView.update('clientSize-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('clientSize-grid');  
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