<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
        'id'=>'recipient-grid',
        'type' => 'striped bordered',
        'dataProvider' => $users,
        'filter'=>$filtersForm,
        'template' => "{pager}{items}{pager}",
        'bulkActionPosition'=>'top',
        'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'medium',
                'id' => 'add-u-btn',
                'label' => Yii::t('mailingList','Добавить в рассылку'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#recipient-grid tr.row-not-selected").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     }); 
                    
                    if(values.length > 0) {
                        $.ajax({
                             url:"email/mailingListUsers", 
                             data: {
                                mlid:window.mlid,
                                ids:values
                             },
                             success:function(data){ 
                                 $("#recipient-grid").yiiGridView("update"); 
                             }
                         });
                     }
                     
                }'                
                ),
            array(
                'buttonType' => 'button',
                'type' => 'warning',
                'size' => 'medium',
                'id' => 'remove-u-b',
                'label' => Yii::t('mailingList','Исключить из рассылки'),
                'click' => 'js:function(checked){
                     var values=[];
                     var valuesIDS=$("#recipient-grid tr.row-selected").find("input:checkbox:checked")
                     valuesIDS.each(function(){
                         values.push($(this).val());
                     }); 
                    
                    if(values.length > 0) {
                        $.ajax({
                             url:"'.Yii::app()->controller->createUrl('mailingListUsersRemove').'", 
                             data: {
                                mlid:window.mlid,
                                ids:values
                             },
                             success:function(data){ 
                                 $("#recipient-grid").yiiGridView("update"); 
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
        'rowCssClassExpression'=>'$data[\'userID\']!=0 ? "row-selected":"row-not-selected"',
        'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',            
                'selectableRows'=>'2',
                'cssClassExpression' => '($data["status"] != 0) ? ($data["status"] == 1) ? "sent" : "no-class" : "not-sent"',
            ),        
            //'id',
            array(
                'header'=>Yii::t('mailingList','Имя'),
                'name'=>'name',
                'value'=>'$data[\'name\']',
            ),
            array(
                'header'=>Yii::t('mailingList','Email'),
                'name'=>'email',
                'value'=>'$data[\'email\']',
            ),            
            array(
                'header'=>Yii::t('mailingList','Дата первой отпр.'),
                'name'=>'stat_date_create',
                'value'=>function($data)
                {
                    return $data['stat_date_create']!==null ? Yii::app()->dateFormatter->formatDateTime($data['stat_date_create'],'short','short') : null;
                },
                'filter'=>false,
                'htmlOptions'=>array('width'=>'150px'),
            ),
            array(
                'header'=>Yii::t('mailingList','Повторная отпр.'),
                'name'=>'stat_date_update',
                'value'=>function($data)
                {
                    return $data['stat_date_update']!==null ? Yii::app()->dateFormatter->formatDateTime($data['stat_date_update'],'short','short') : null;
                },
                'filter'=>false,
                'htmlOptions'=>array('width'=>'150px'),
            ),
            array(
                'header'=>Yii::t('mailingList', 'Промо код'),
                'name'=>'promo_code',
                'value'=>'$data[\'promo_code\']',
            ),
            array(
                'header'=>Yii::t('mailingList', 'Посл.просм.изделие'),
                'name'=>'last_item_id',
                'value'=>'$data[\'last_item_id\']',
            ),            
            //'userID',
            'status',
            array(
                'class'=>'ButtonColumn',
                'template'=>'{add} {delete}',
                'buttons'=>array(
                    'add'=>array(
                        'label'=>Yii::t('mailingList', 'Добавить в рассылку'),
                        'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_plus.png',
                        'url'=>function($data)
                        {
                            return Yii::app()->controller->createUrl('mailingListUsers',array('ids'=>array($data['id']), 'mlid'=>Yii::app()->request->getQuery('id')));
                        },
                        'visible'=>'$data[\'userID\']==0',
                        'click'=>"
                            function() {
                                $.fn.yiiGridView.update('recipient-grid', {
                                    type:'GET',
                                    url:$(this).attr('href'),
                                    success:function(data) {
                                        $('#recipient-grid').yiiGridView('update'); 
                                    },
                                });
                                return false;
                            }",
                    ),                
                    'delete'=>array(
                        'label'=>Yii::t('mailingList', 'Исключить из рассылки'),
                        'url'=>function($data)
                        {
                            return Yii::app()->controller->createUrl('mailingListUsersRemove',array('ids'=>array($data['id']), 'mlid'=>Yii::app()->request->getQuery('id')));
                        },
                        'visible'=>'$data[\'userID\']!=0',
                        //'visible'=>'$data->is_locked <> 1 && $data->id <> Yii::app()->user->id && $data->created_by_id == Yii::app()->user->id',
                        'click'=>"
                            function() {
                                $.fn.yiiGridView.update('recipient-grid', {
                                    type:'GET',
                                    url:$(this).attr('href'),
                                    success:function(data) {
                                        $('#recipient-grid').yiiGridView('update'); 
                                    },
                                });
                                return false;
                            }",
                    ),                                                
                ),
            ),            
        ),
    ));
    ?>
    
<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    //->registerCoreScript('jquery')
    ->registerScript(__FILE__,"
    window.mlid=".$mlid.";
    ", CClientScript::POS_READY
);    
?>     
