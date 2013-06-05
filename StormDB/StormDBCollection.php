<?php

class StormDBCollection extends StormDBBase
{
	public $name;
	public $where;

	public function __construct($name, $file)
	{
		$this->name = $name;
	}

	public function where($where)
	{
		$this->where = $where;
		return $this;
	}

	public function find()
	{

	}



	public function insert()
	{
		
	}

	/**
	 * rename() function
	 *
	 * @param mixed New name
	 * @return void
	 **/
	public function rename($new)
	{

	}
}
