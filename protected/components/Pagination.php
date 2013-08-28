<?php
class Pagination extends CPagination
{
	public $sizeVar='size';
	private $_sizeOptions;

	public function setPageSize($value)
	{
		if($this->getSizeOptions()===null || !isset($_GET[$this->sizeVar]))
			parent::setPageSize($value);
	}

	public function getSizeOptions()
	{
		return $this->_sizeOptions;
	} 

	public function setSizeOptions($value)
	{
		$this->_sizeOptions=$value;

		if(isset($_GET[$this->sizeVar]))
		{
			if(in_array($_GET[$this->sizeVar],$this->_sizeOptions))
				parent::setPageSize($_GET[$this->sizeVar]);
			else
				unset($_GET[$this->sizeVar]);
		}
	}

	public function createSizeUrl($controller,$size)
	{
		$params='';
        //Todo: refresch grid via ajax
        //$params=$this->params===null ? $_GET : $this->params;
        if(isset($_GET['defaultTab']))
            $params = $_GET;
            
		$params[$this->sizeVar]=$size;

		return $controller->createUrl($this->route,$params);
	}
}