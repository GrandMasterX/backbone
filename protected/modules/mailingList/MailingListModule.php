<?php
class MailingListModule extends CWebModule
{
	public $layout='application.modules.admin.views.layouts.main';

	protected function init()
	{
		parent::init();

		Yii::app()->configure(array(
			'components'=>array(
				'errorHandler'=>array(
					'errorAction'=>'mailingList/default/error',
				),
			),
		));

		$this->import=array(
			'mailingList.components.*',
		);
	}
}