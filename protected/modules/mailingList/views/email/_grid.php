<?php $this->widget('GridView',array(
	'id'=>'mailing-list-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
        'title',
        array(
            'name'=>'template_id',
            'value'=>'($data->template->title) ? $data->template->title : Yii::t("mailingList", "Нет шаблона")',
        ),
        array(
            'name'=>'subject',
            'value'=>'($data->subject) ? $data->subject : Yii::t("mailingList", "Тема не указана")',
        ),
//        array(
//            'name'=>'status',
//            'value'=>'($data->status || $data->status!=0) ? $data->status : Yii::t("mailingList", "Новая, не рассылалась")',
//        ),
        array(
            'name'=>'current_sending_state',
            'value'=>'$data->sentCount . \'/\' .$data->notSentCount .\' из \'. $data->user_count',
        ),
		array(
			'name'=>'last_sent_time',
			'value'=>function($data)
			{
				return ($data->last_sent_time) 
                    ? Yii::app()->dateFormatter->formatDateTime($data->last_sent_time,'short','short')
                    : Yii::t('mailingList','Не рассылалась');
			},
			'filter'=>false,
		),
        array(
            'name'=>'sent_count',
            'value'=>'($data->sent_count) ? $data->sent_count : 0',
            'filter'=>false,
        ),
        //'user_count',
		array(
			'class'=>'ButtonColumn',
			'template'=>'{email} {emailnotsent} {user} {update} {delete}',
			'buttons'=>array(
                'email'=>array(
                    'label'=>Yii::t('mailingList', 'Разослать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_envelope_w.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('sendEmailViaAjax',array('id'=>$data->id));
                    },
                    'options'=>array(
                        'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                                'beforeSend'=>"function(){
                                    if(!confirm('Разослать?')) return false;
                                }",
                                'success'=>"function(data){
                                    showMessage(data);
                                    $.fn.yiiGridView.update('mailing-list-grid');
                                    return false;
                                }"                                                                                               
                        ),                    
                    ),
                ),
                'emailnotsent'=>array(
                    'label'=>Yii::t('mailingList', 'Разослать по неотправленным'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_envelope.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('sendEmailViaAjax',array('id'=>$data->id,'notSentOnly'=>1));
                    },
                    'visible'=>'$data->notSentCount > 0',
                    'options'=>array(
                        'ajax'=>array(
                            'type'=>'POST',
                            'url'=>"js:$(this).attr('href')",
                            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                            'beforeSend'=>"function(){
                                    if(!confirm('Разослать по неотправленным?')) return false;
                                }",
                            'success'=>"function(data){
                                    showMessage(data);
                                    $.fn.yiiGridView.update('mailing-list-grid');
                                    return false;
                                }"
                        ),
                    ),
                ),
                'user'=>array(
                    'label'=>Yii::t('mailingList', 'Получатели'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_user.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('email/mailingListUsers',array('id'=>$data->id));
                    },
                    //'visible'=>'$data[\'userID\']==0',
                ),                
                'delete'=>array(
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('markAsDeleted',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_locked <> 1 && $data->id <> Yii::app()->user->id && $data->created_by_id == Yii::app()->user->id',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('mailingList', 'Вы уверены что хотите удалить эту рассылку?') ."')) return false;
                            $.fn.yiiGridView.update('mailing-list-grid', {
                                type:'GET',
                                url:$(this).attr('href'),
                                success:function(data) {
                                    showMessage(data);
                                    $.fn.yiiGridView.update('mailing-list-grid');  
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
        'header'=>Yii::t('mailingList', 'Позиций на странице: '),      
    ),    
)); ?>