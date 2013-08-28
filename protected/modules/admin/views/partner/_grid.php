<?php $this->widget('GridView',array(
	'id'=>'partner-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
		'company_title',
		'email',
        'phone',
		array(
			'name'=>'create_time',
			'value'=>function($data)
			{
				return Yii::app()->dateFormatter->formatDateTime($data->create_time,'short','short');
			},
			'filter'=>false,
		),
//		array(
//			'header'=>'Изменение',
//			'name'=>'update_time',
//			'value'=>function($data)
//			{
//				return $data->update_time!==null ? Yii::app()->dateFormatter->formatDateTime($data->update_time,'short','short') : null;
//			},
//			'filter'=>false,
//		),
		array(
			'class'=>'ButtonColumn',
			'template'=>'{email} {update} {block} {unblock} {delete}',
			'buttons'=>array(
                'import'=>array(
                    'label'=>Yii::t('partner', 'Импортировать изделия (xml)'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_import.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('importItems',array('id'=>$data->id));
                    },
                    'options'=>array(
                        'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                                'beforeSend'=>"function(data){
                                    if(!confirm('". Yii::t('partner', 'Запустить xml импорт изделий?') ."')) return false;
                                }", 
                                'success'=>"function(data){
                                    showMessage(data);
                                    $.fn.yiiGridView.update('partner-grid');
                                }"                                                                                               
                        ),                    
                    ),
                ),
                'email'=>array(
                    'label'=>Yii::t('partner', 'Отправить пароль на почту'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_envelope.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('emailPassword',array('id'=>$data->id));
                    },
                    'options'=>array(
                        'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                                'success'=>"function(data){
                                    showMessage(data);
                                    $.fn.yiiGridView.update('partner-grid');
                                }"                                                                                               
                        ),                    
                    ),
                ),                
                'block'=>array(
                    'label'=>Yii::t('partner', 'Заблокировать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('partner', 'Вы уверены что хотите заблокировать этого партнера?') ."')) return false;
                            $.fn.yiiGridView.update('partner-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('partner-grid');
                                },
                            });
                            return false;
                        }",
                ),                
                'unblock'=>array(
                    'label'=>Yii::t('partner', 'Разблокировать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('partner', 'Вы уверены что хотите разблокировать этого партнера?') ."')) return false;
                            $.fn.yiiGridView.update('partner-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('partner-grid');  
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
                            if(!confirm('". Yii::t('partner', 'Вы уверены что хотите удалить этого партнера?') ."')) return false;
                            $.fn.yiiGridView.update('partner-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('partner-grid');  
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
        'header'=>Yii::t('partner', 'Позиций на странице: '),      
    ),    
)); ?>