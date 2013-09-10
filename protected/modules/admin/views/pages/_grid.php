<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'user-grid',
    'type' => 'striped bordered',
    'dataProvider'=>$dataProvider,
    'filter'=>$search,
    'template' => "{pager}{items}{pager}",
    'bulkActionPosition'=>'top',
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'medium',
                'id' => 'unblock',
                    'label' => Yii::t('pages','Разблокировать'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#user-grid tr td.blocked-class").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     }); 
                    
                    if(values.length == 1) {
                        $.ajax({
                             url:"'.Yii::app()->controller->createUrl('block').'",
                             data: {
                                ids:values
                             },
                             success:function(data){ 
                                 $("#user-grid").yiiGridView("update");
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
                'label' => Yii::t('user','Заблокировать'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#user-grid tr td.not-blocked-class").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     }); 
                    
                    if(values.length == 0) {
                        $.ajax({
                             url:"'.Yii::app()->controller->createUrl('block').'",
                             data: {
                                ids:values
                             },
                             success:function(data){ 
                                 $("#user-grid").yiiGridView("update");
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
                'label' => Yii::t('user','Удалить'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#user-grid").find("input:checkbox:checked")
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
                                 $("#user-grid").yiiGridView("update");
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
    //'rowCssClassExpression'=>'$data[\'userID\']!=0 ? "row-selected":"row-not-selected"',
    'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'selectableRows'=>'2',
            'cssClassExpression' => '($data->is_blocked > 0) ? "blocked-class" : "not-blocked-class"',
        ),
        array(
            'name'=>'name',
            'value'=>'$data->name',
            'htmlOptions'=>array(
                'width'=>'100px',
            ),
        ),
        array(
            'name'=>'create_time',
            'value'=>function($data)
            {
                return Yii::app()->dateFormatter->formatDateTime($data->create_time,'short','short');
            },
            'htmlOptions'=>array(
                'width'=>'100px',
            ),
            'filter'=>false,
        ),
        array(
            'class'=>'ButtonColumn',
            'template'=>' {update} {block} {unblock} {delete}',
            'htmlOptions'=>array(
                'width'=>'50px',
            ),
            'buttons'=>array(
                'block'=>array(
                    'label'=>Yii::t('user', 'Заблокировать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_eye_visible.png',
                    'url'=>function($data)
                    {
                        return Yii::app()->controller->createUrl('block',array('id'=>$data->id));
                    },
                    'visible'=>'$data->is_blocked == 0',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('user', 'Вы уверены что хотите заблокировать страницу?') ."')) return false;
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
                    'visible'=>'$data->is_blocked == 1',
                    'click'=>"
                        function() {
                            if(!confirm('". Yii::t('user', 'Вы уверены что хотите разблокировать страницу?') ."')) return false;
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
                    'visible'=>'($data->is_blocked <> 1 && $data->id <> Yii::app()->user->id)',//(Yii::app()->user->checkAccess(\'block_admin\')) &&
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
));
?>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    //->registerCoreScript('jquery')
    ->registerScript(__FILE__,"
    ", CClientScript::POS_READY
    );
?>     
