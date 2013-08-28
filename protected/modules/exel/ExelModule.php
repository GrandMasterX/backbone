<?php
class ExelModule extends CWebModule
{
	public $layout='main';

	protected function init()
	{
		parent::init();

		Yii::app()->configure(array(
			'components'=>array(
				'errorHandler'=>array(
					'errorAction'=>'exel/default/error',
				),
			),
		));

		$this->import=array(
			'exel.components.*',
		);
	}
}