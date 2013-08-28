<?php $this->widget('GridView',array(
	'id'=>'language-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
		'title',
		'code',
		array(
			'class'=>'ButtonColumn',
			'template'=>'{update} {block} {unblock} {delete}',
			'buttons'=>array(
                'block'=>array(
                    'label'=>Yii::t('language', 'Выключить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите выключить этот язык?')) return false;
                            $.fn.yiiGridView.update('language-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('language-grid');
                                },
                            });
                            return false;
                        }",
                ),                
                'unblock'=>array(
                    'label'=>Yii::t('language', 'Включить'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите включить этот язык?')) return false;
                            $.fn.yiiGridView.update('language-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('language-grid');  
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
                    'visible'=>'$data->is_locked <> 1 && $data->id <> Yii::app()->user->id && $data->created_by_id == Yii::app()->user->id',
                    'click'=>"
                        function() {
                            if(!confirm('Вы уверены что хотите удалить этот язык?')) return false;
                            $.fn.yiiGridView.update('language-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('language-grid');  
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