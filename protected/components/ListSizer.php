<?php
class ListSizer extends BaseSizer
{
	public $header;
	public $footer;
	public $promptText;
	public $sizeTextFormat;
	public $htmlOptions=array();

	public function init()
	{
		if($this->header===null)
			$this->header=Yii::t('app','Page size: ');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();

		if($this->promptText!==null)
			$this->htmlOptions['prompt']=$this->promptText;

		if(!isset($this->htmlOptions['onchange']))
            $this->htmlOptions['onchange']="if(this.value!='') {window.location=this.value;};";
        
    }

	public function run()
	{
		if(($pageCount=$this->getPageCount())<=1 || $this->getSizeOptions()===null)
			return;

        $sizes=array();
        
		foreach($this->getSizeOptions() as $size)
			$sizes[$this->createSizeUrl($size)]=$this->generateSizeText($size);

		$selection=$this->createSizeUrl($this->getPageSize());
        
		echo $this->header;
		echo CHtml::dropDownList($this->getId(),$selection,$sizes,$this->htmlOptions);
		echo $this->footer;
	}

	protected function generateSizeText($size)
	{
		if($this->sizeTextFormat!==null)
			return sprintf($this->sizeTextFormat,$size);
		else
			return $size;
	}
}