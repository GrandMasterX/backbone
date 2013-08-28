<?php $this->widget('GridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
		'name',
        array(
            'name'=>'auth_role',
            'value'=>'$data->getRole()'
        ),
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
		array(
			'class'=>'ButtonColumn',
			'template'=>'{email} {update} {block} {unblock} {delete}',
			'buttons'=>array(
                'email'=>array(
                    'label'=>Yii::t('user', 'Отправить пароль на почту'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_envelope.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('emailPassword',array('id'=>$data->id));
                    },
                    //'visible'=>'Yii::app()->user->checkAccess(\'email_password_admin\')',
                    'options'=>array(
                        'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                                'success'=>"function(data){
                                    showMessage(data);
                                    $.fn.yiiGridView.update('user-grid');
                                }"                                                                                               
                        ),                    
                    ),
                ),
                'block'=>array(
                    'label'=>Yii::t('user', 'Заблокировать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('user', 'Вы уверены что хотите заблокировать этого пользователя?') ."')) return false;
                            $.fn.yiiGridView.update('user-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('user-grid');
                                },
                            });
                            return false;
                        }",
                ),                
                'unblock'=>array(
                    'label'=>Yii::t('user', 'Разблокировать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('user', 'Вы уверены что хотите разблокировать этого пользователя?') ."')) return false;
                            $.fn.yiiGridView.update('user-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('user-grid');  
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
                    'visible'=>'($data->is_locked <> 1 && $data->id <> Yii::app()->user->id && $data->created_by_id == Yii::app()->user->id)',//(Yii::app()->user->checkAccess(\'block_admin\')) &&
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('user', 'Вы уверены что хотите удалить этого пользователя?') ."')) return false;
                            $.fn.yiiGridView.update('user-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('user-grid');  
                                },
                            });
                            return false;
                        }",
                ),                                                
			),
		),//ButtonColumn
	),
    'template'=>"{sizer}\n{items}\n{pager}",
    'cssFile'=>false,   
    'pager'=>array(
        'class'=>'LinkPager',
        'header'=>'',
    ),        
    'sizer'=>array(
        'class'=>'ListSizer',
        'header'=>Yii::t('user', 'Позиций на странице: '),
    ),    
)); ?>