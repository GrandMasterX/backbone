<?php $this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'log-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$filtersForm,
	'columns'=>array(
        array(
            'name'=>'code',
            'value'=>'($data["code"]) ? $data["code"] : Yii::t("logging", "Нет данных")',
            'htmlOptions'=>array('width'=>'50px'),
        ),        
        array(
            'name'=>'email',
            'value'=>'($data["email"]) ? $data["email"] : Yii::t("logging", "Нет данных")',
            'htmlOptions'=>array('width'=>'130px'),
        ),
//        array(
//            'name'=>'clientByEmail_search',
//            'value'=>'($data->client) ? $data->client->email : ($data->email) ? $data->email : Yii::t("logging", "Нет данных")',
//            'htmlOptions'=>array('width'=>'130px'),
//        ),        
        array(
            'name'=>'action',
            'filter' =>Logging::filterDataToArray(),
        ),         
        array(
            'name'=>'client_ip',
            'htmlOptions'=>array('width'=>'80px'),  //100
        ),
        array(
            'name'=>'country',
            'htmlOptions'=>array('width'=>'40px'),
        ),
        array(
            'name'=>'city',
            'htmlOptions'=>array('width'=>'60px'),
        ),
        array(
            'name'=>'device',
            //'filter' =>Logging::deviceToArray(),
            'htmlOptions'=>array('width'=>'60px'),    ///100
        ),                        
        array(
            'name'=>'os',
            //'filter' =>Logging::osToArray(),
            'htmlOptions'=>array('width'=>'100px'),
        ),                                
        array(
            'name'=>'browser',
            //'filter' =>Logging::browserToArray(),
            'htmlOptions'=>array('width'=>'100px'),
        ),                                
        array(
            'name'=>'browser_v',
            'htmlOptions'=>array('width'=>'50px'),  //100
        ),                                
        array(
            'name'=>'create_time',
            'value'=>function($data)
            {
                return $data['create_time']!==null ? Yii::app()->dateFormatter->formatDateTime($data['create_time'],'short','short') : null;
            },
            'filter'=>false,
            'htmlOptions'=>array('width'=>'100px'),
        ),        
//		array(
//			'class'=>'ButtonColumn',
//			'template'=>'{update} {block} {unblock} {delete}',
//			'buttons'=>array(
//                'block'=>array(
//                    'label'=>Yii::t('language', 'Выключить'),
//                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
//                    'url'=>function($data)
//                    {
//                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
//                    },
//                    'visible'=>'$data->is_blocked < 1 && $data->is_locked <> 1',
//                    'click'=>"
//                        function() {
//                            if(!confirm('Вы уверены что хотите выключить этот размер?')) return false;
//                            $.fn.yiiGridView.update('itemSize-grid', {
//                                type:'GET',
//                                url:$(this).attr('href'),
//                                success:function(data) {
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('itemSize-grid');
//                                },
//                            });
//                            return false;
//                        }",
//                ),                
//                'unblock'=>array(
//                    'label'=>Yii::t('language', 'Включить'),
//                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_lock.png',
//                    'url'=>function($data)
//                    {
//                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
//                    },
//                    'visible'=>'$data->is_blocked > 0 && $data->is_locked <> 1',
//                    'click'=>"
//                        function() {
//                            if(!confirm('Вы уверены что хотите включить этот размер?')) return false;
//                            $.fn.yiiGridView.update('itemSize-grid', {
//                                type:'GET',
//                                url:$(this).attr('href'),
//                                success:function(data) {
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('itemSize-grid');  
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
//                            if(!confirm('Вы уверены что хотите удалить этот размер?')) return false;
//                            $.fn.yiiGridView.update('itemSize-grid', {
//                                type:'GET',
//                                url:$(this).attr('href'),
//                                success:function(data) {
//                                    showMessage(data);
//                                    $.fn.yiiGridView.update('itemSize-grid');  
//                                },
//                            });
//                            return false;
//                        }",
//                ),                                                
//			),
//		),
	),
    'template'=>"{summary}{items}\n{pager}",
    'cssFile'=>Yii::app()->baseUrl.'/static/admin/gridview/styles.css',   
    'pager'=>array(
        'class'=>'CLinkPager',
        'header'=>'',
    ),        
//    'sizer'=>array(
//        'class'=>'ListSizer',
//        'header'=>'Позиций на странице: ',
//    ),    
)); ?>
