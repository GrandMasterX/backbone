<?php 
/*$this->widget('bootstrap.widgets.TbExtendedGridView', array(
'filter'=>$person,
'type'=>'striped bordered',
'dataProvider' => $gridDataProvider,
'template' => "{items}",
'columns' => array_merge(array(
array(
'class'=>'bootstrap.widgets.TbRelationalColumn',
'name' => 'firstLetter',
'url' => $this->createUrl('site/relational'),
'value'=> '"test-subgrid"',
'afterAjaxUpdate' => 'js:function(tr,rowid,data){
bootbox.alert("I have afterAjax events too!
This will only happen once for row with id: "+rowid);
}'
)
),$gridColumns),
));*/

//echo "<pre><br>$dataFrom";       die;
 
echo Yii::t('LogAnalyzer.main', 'Log Filter') ?>:
<a href="?level=error" class="filter-log" rel='error'><span class="label label-important">[error]</span></a>
<a href="?level=warning" class="filter-log" rel='warning'><span class="label label-warning">[warning]</span></a>
<a href="?level=info" class="filter-log" rel='info'><span class="label label-info">[info]</span></a>
<a href="?level=trace" class="filter-log" rel='trace'><span class="label label-trace">[trace]</span></a>
<a href="?level=profile" class="filter-log" rel='profile'><span class="label label-profile">[profile]</span></a>
<a href="?level=all" class="filter-log" rel='all'><span class="label label-inverse"><?php echo Yii::t('LogAnalyzer.main', 'All') ?></span></a>

<?php                     
/*$grid = $this->widget('zii.widgets.grid.CGridView',array(  */
$grid = $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'log-grid',
	'dataProvider'=>$dataProvider,
    'filter'=>$search,
    'fixedHeader' => true,
    'headerOffset' => 0, // 40px is the height of the main navigation at bootstrap
    'type'=>'bordered',

	'columns'=>array(
        array(
            'name'=>'level',
            'type' => 'raw',
            'value'=>function($data) { 
                switch($data['level']) {
                    case 'error': $class = 'label-important';   break;
                    case 'warning': $class = 'label-warning';   break;
                    case 'info': $class = 'label-info';   break;
                    case 'trace': $class = 'label-trace';   break;
                    case 'profile': $class = 'label-profile';   break;
                    default: $class = 'label-inverse';
                }
                return "<span class=\"label $class\">[{$data['level']}]</span>"; 
            },
/*          'cssClassExpression' => function($row,$data,$component){
                return ($data->level=='info') ? 'badge-info' : 'badge-warning';
            },*/
            'filter'=>false,
            'htmlOptions'=>array('style' => 'width:60px; text-align:center;'),
        ), 
        array(
            'name'=>'item_id',
            'value'=>'($data->item) ? $data->item->code : \'-\'',
            'htmlOptions'=>array('width'=>'50px'),
        ),        
        array(
            'name'=>'email',
            'value'=>'($data->client) ? $data->client->email : \'-\'',
            ///'value'=>'$data->client->email',
            'htmlOptions'=>array('width'=>'130px'),
        ),
//        array(
//            'name'=>'clientByEmail_search',
//            'value'=>'($data->client) ? $data->client->email : ($data->email) ? $data->email : Yii::t("logging", "Нет данных")',
//            'htmlOptions'=>array('width'=>'130px'),
//        ),        
/*        array(
            'name'=>'message',
            'filter' =>Logging::filterDataToArray(),
        ),*/
        array(
            'class'=>'bootstrap.widgets.TbRelationalColumn',
            'name' => 'message',   //'message',
            'url' => Yii::app()->createUrl('/register/ShowChain'),      ///'js:rowid'),  100     array('id'=>$data->id)     , array( 'id'=>$data["id"]
            ///'htmlOptions' => array('class'=>'tbrelational-column'),
            'filter' =>Logging::filterDataToArray(@$level),
        ),
         array(
            'name' => 'comment',
            'header' => 'Комментарий',
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'htmlOptions' => array('style' => 'width:15%; text-align:center;'),    //headerHtmlOptions
            'editable' => array(
                'type' => 'text',
                'url' => Yii::app()->createUrl('/register/SaveComment'),
                        ///array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken)
                       //, array('name', 'value', 'pk')
                'placement' => 'right',
                'inputclass' => 'span3',
            ),
         ),
/*        array(
            'name'=>'client_ip',
            'htmlOptions'=>array('width'=>'80px'),  //100
        ),*/
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
/*        array(
            'name'=>'browser',
            //'filter' =>Logging::browserToArray(),
            'htmlOptions'=>array('width'=>'100px'),
        ),                                
        array(
            'name'=>'browser_v',
            'htmlOptions'=>array('width'=>'50px'),  //100
        ),*/                               
        array(
            'name'=>'logtime',
            'value'=>function($data)
            {
                return $data['logtime']!==null ? Yii::app()->dateFormatter->formatDateTime($data['logtime'],'short','short') : null;
            },
            'filter'=>false,
            'htmlOptions'=>array('width'=>'110px'),
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
    'template'=>"{items}\n{pager}{summary}",
    'cssFile'=>Yii::app()->baseUrl.'/static/admin/gridview/styles.css',   
    'pager'=>array(
        'class'=>'CLinkPager',
        'header'=>'',
    ),
//    'sizer'=>array(
//        'class'=>'ListSizer',
//        'header'=>'Позиций на странице: ',
//    ),
));

////  https://github.com/yiisoft/yii/issues/1313              /*    'afterAjaxUpdate' => 'js:function(tr,rowid,data){*/
/*$this->attachAjaxUpdateEvent($grid);
Yii::app()->getClientScript()->registerScript('ajax-update', '
$("#log-grid").on("ajaxUpdate", function() {
        bootbox.alert("I have afterAjax events too! This will only happen once for row with id: "+rowid);
});
');*/
   
 ?>
