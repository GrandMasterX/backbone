<?php
class ActiveDataProvider extends CActiveDataProvider
{
	public function __construct($modelClass,$config=array())
	{
		$this->setPagination(new Pagination);

		if(($id=$this->getId())!='')
		{
			$this->setPagination(array(
				'sizeVar'=>$id.'_size',
			));
		}

		parent::__construct($modelClass,$config);
	}
}