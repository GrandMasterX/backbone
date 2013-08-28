<?php $this->widget('GridView',array(
	'id'=>'client-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
        'name',
		'email',
        //'phone',
//		array(
//			'name'=>'create_time',
//			'value'=>function($data)
//			{
//				return Yii::app()->dateFormatter->formatDateTime($data->create_time,'short','short');
//			},
//			'filter'=>false,
//		),
		array(
			'class'=>'ButtonColumn',
			'template'=>'{suitable_items} {update}',
			'buttons'=>array(
                'suitable_items'=>array(
                    'label'=>Yii::t('client', 'Подбор размеров'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_suitable_items.png',
                    'options'=>array(
                        'target'=>'_blank',
                    ),
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('suitableItems',array('parent_id'=>4,'lastuserid'=>$data->id));
                    },
                ),
//                'email'=>array(
//                    'label'=>Yii::t('client', 'Отправить пароль на почту'),
//                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_envelope.png',
//                    'url'=>function($data)
//                    {
//                        return Yii::app()->controller->createUrl('emailPassword',array('id'=>$data->id));
//                    },
//                    'options'=>array(
//                        'ajax'=>array(
//                                'type'=>'POST',
//                                'url'=>"js:$(this).attr('href')",
//                                'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
//                                'success'=>"function(data){
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('client-grid');
//                                }"
//                        ),
//                    ),
//                ),
//                'block'=>array(
//                    'label'=>Yii::t('client', 'Заблокировать'),
//                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
//                    'url'=>function($data)
//                    {
//                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
//                    },
//                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
//                    'click'=>"
//                        function() {
//                            if(!confirm('". Yii::t('client', 'Вы уверены что хотите заблокировать этого клиента?') ."')) return false;
//                            $.fn.yiiGridView.update('client-grid', {
//                                type:'GET',
//                                url:$(this).attr('href'),
//                                success:function(data) {
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('client-grid');
//                                },
//                            });
//                            return false;
//                        }",
//                ),
//                'unblock'=>array(
//                    'label'=>Yii::t('client', 'Разблокировать'),
//                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
//                    'url'=>function($data)
//                    {
//                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
//                    },
//                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
//                    'click'=>"
//                        function() {
//                            if(!confirm('". Yii::t('client', 'Вы уверены что хотите разблокировать этого клиента?') ."')) return false;
//                            $.fn.yiiGridView.update('client-grid', {
//                                type:'GET',
//                                url:$(this).attr('href'),
//                                success:function(data) {
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('client-grid');
//                                },
//                            });
//                            return false;
//                        }",
//                ),
//                'delete'=>array(
//                    'url'=>function($data)
//                    {
//                        return Yii::app()->controller->createUrl('markAsDeleted',array('id'=>$data->id));
//                    },
//                    'visible'=>'$data->is_locked <> 1 && $data->id <> Yii::app()->user->id && $data->created_by_id == Yii::app()->user->id',
//                    'click'=>"
//                        function() {
//                            if(!confirm('". Yii::t('client', 'Вы уверены что хотите удалить этого клиента?') ."')) return false;
//                            $.fn.yiiGridView.update('client-grid', {
//                                type:'GET',
//                                url:$(this).attr('href'),
//                                success:function(data) {
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('client-grid');
//                                },
//                            });
//                            return false;
//                        }",
//                ),
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
        'header'=>Yii::t('client', 'Позиций на странице: '),      
    ),    
)); ?>