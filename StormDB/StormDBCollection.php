<?php

class StormDBCollection extends StormDBBase
{
	private $name;
	private $where;
	private $base;

	public function __construct($name, $base)
	{
		$this->name = $name;
		$this->base = $base;
	}

	public function where($where)
	{
		$this->where = $where;
		return $this;
	}


	/**
	* find() function
	* returns results form database
	*/
	public function find()
	{
		return $this->base->build[$this->name];
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
