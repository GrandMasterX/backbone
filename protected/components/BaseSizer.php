<?php
class BaseSizer extends CBasePager
{
	protected function createSizeUrl($size)
	{
		return $this->getPages()->createSizeUrl($this->getController(),$size);
	}

	public function getSizeOptions()
	{
		return $this->getPages()->getSizeOptions();
	}    

	public function setSizeOptions($value)
	{
		return $this->getPages()->setSizeOptions($value);
	}  
} 