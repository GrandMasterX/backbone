<?php
class ButtonColumn extends CButtonColumn
{
	public function init()
	{
		$this->viewButtonImageUrl=Yii::app()->baseUrl.'/static/admin/gridview/zoom.png';
		$this->updateButtonImageUrl=Yii::app()->baseUrl.'/static/admin/gridview/b_pencil.png';
		$this->deleteButtonImageUrl=Yii::app()->baseUrl.'/static/admin/gridview/b_trash.png';
		parent::init();
	}
}