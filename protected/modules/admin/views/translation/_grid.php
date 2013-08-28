<?php $this->widget('GridView',array(
	'id'=>'translation-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
        'category',
		'message',
        array(
            'name'=>'translation',
            'filter'=>false,
        ),         
		array(
			'class'=>'ButtonColumn',
			'template'=>'{create} {update}',
            'buttons'=>array(
                'create'=>array(
                    'label'=>Yii::t('translation', 'Создать'),
                    'imageUrl'=>Yii::app()->baseUrl.'/static/admin/gridview/b_plus.png',                
                    'url'=>function($data)
                    {
                            return Yii::app()->controller->createUrl('create',array('id'=>$data->id, 'language'=>$data->language));
                    },
                    'visible'=>'is_null($data->translation_id)',
                ),
                'update'=>array(
                    'url'=>function($data)
                    {
                            return Yii::app()->controller->createUrl('update',array('id'=>$data->translation_id, 'language'=>$data->language));
                    },
                    'visible'=>'!is_null($data->translation_id)',
                ),                
            ),            
        ),
	),
    'cssFile'=>false,   
    'pager'=>array(
        'class'=>'LinkPager',
        'header'=>'',
    ),        
    'sizer'=>array(
        'class'=>'ListSizer',
        'header'=>'Позиций на странице: ',
    ),    
)); 
?>
