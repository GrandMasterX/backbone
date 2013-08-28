<?php
class AdminModule extends CWebModule
{
	public $layout='main';

	protected function init()
	{
		parent::init();

		Yii::app()->configure(array(
			'components'=>array(
				'errorHandler'=>array(
					'errorAction'=>'admin/default/error',
				),
			),
		));

		$this->import=array(
			'admin.components.*',
		);
	}
}