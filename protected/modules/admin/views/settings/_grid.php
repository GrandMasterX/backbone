<?php $this->widget('GridView',array(
	'id'=>'settings-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$search,
	'columns'=>array(
		'title',
		'code',
        'value',
        'info',
		array(
			'class'=>'ButtonColumn',
			'template'=>'{update}',
            'buttons'=>array(
                'update'=>array(
                    'url'=>function($data)
                    {
                        return Settings::getProperUrlForSettingsUpdate('update', $data->id);
                    },
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