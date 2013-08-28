<?php
Yii::import('zii.widgets.grid.CGridView');

class GridView extends CGridView
{
	public $enableSizing=true;
	public $sizer=array('class'=>'ListSizer');
	public $sizerCssClass='sizer';
	public $template="{summary}\n{items}\n{pager}\n{sizer}";

	public function renderSizer()
	{
		if(!$this->enableSizing)
			return;

		$sizer=array();
		$class='LinkSizer';

		if(is_string($this->sizer))
			$class=$this->sizer;
		elseif(is_array($this->sizer))
		{
			$sizer=$this->sizer;

			if(isset($sizer['class']))
			{
				$class=$sizer['class'];
				unset($sizer['class']);
			}
		}

		$sizer['pages']=$this->dataProvider->getPagination();

		if($sizer['pages']->getPageCount()>1)
		{
			echo '<div class="'.$this->sizerCssClass.'">';
			$this->widget($class,$sizer);
			echo '</div>';
		}
		else
			$this->widget($class,$sizer);
	}
} 