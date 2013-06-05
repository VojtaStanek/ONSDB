<?php

class StormDB extends StormDBBase
{
	protected $base;

	public function __construct()
	{
		$this->base = parent::__construct(func_get_args());
		$this->load();
		$this->debugMsg(array('StormDB loaded:' => $this));
	}

	private function load() 
	{
		$this->base->dataFile = file($this->base->fileName);

		$last = array(-1 => -1);
		$beforeType = 0;

		$data = array();
		$keys = array();

		// Collections, data, types, extends loading
		foreach ($this->base->dataFile as $key => $value) {
			$type = substr($value, 0, 1)*1;
			$data = substr($value, 1, strlen($value)-2);
			$this->base->types[] = $type;
			$this->base->data[] = $data;
			$this->base->parents[$key] = $last[$type-1];
			
			if($type-1 > $beforeType) {
				$line = $key+1;
				$excMsg = "Incorrect declaration of type in '".$this->base->database."' line ".$line;
				throw new StormDBException($excMsg, 0);
			}

			if ($type == 0) {
				$this->base->collections[] = $data;
				
			}

			$last[$type] = $key;
			$beforeType = $type;
		}

		$parentsBuild = array('BASE' => array());

		for ($depth=0; $depth < 10; $depth++) { 
			foreach ($this->base->types as $key => $type) {
				if ($type == $depth) {

					if($this->base->parents[$key] >= 0) {
						if(!isset($parentsBuild[$this->base->data[$this->base->parents[$key]]]))
							$parentsBuild[$this->base->data[$this->base->parents[$key]]] = array();
						$parentsBuild[$this->base->data[$this->base->parents[$key]]][$this->base->data[$key]] = $this->base->data[$key];
					} else {
						$parentsBuild['BASE'][$this->base->data[$key]] = $this->base->data[$key];
					}

				}
			}

			

		}
		$this->base->build = buildTree($parentsBuild, 'BASE');
	}


	public function reload($debugMsg = '')
	{
		$this->resetData();
		$this->base->load();
		$this->debugMsg(array('StormDB reloaded '.$debugMsg => $this));
	}

	public function collection($name)
	{
		if($this->__isset($name)) {
			return new StormDBCollection($name, $this->base);
		}
		return false;
	}

	public function add($data)
	{
	// --DEV
		if (!is_array($data)) {
			$name = $data;
			if (!$this->__isset($name)) {
				$handle = fopen($this->base->fileName, 'a');
				fwrite($handle, PHP_EOL.'0'.$name);
				fclose($handle);
				$this->reload('add coll. '.$name);
			} else {
				throw new StormDBException("Can't set multiple collections with same name.");
			}
		} else {
			foreach ($data as $name => $value) {
				if ($this->__isset($name)) {
					$handle = fopen($this->base->fileName, 'a');
					fwrite($handle, PHP_EOL.'0'.$name);
					fclose($handle);
					$this->reload('add coll. '.$name);
				} else {
					throw new StormDBException("Can't set multiple collections with same name.");
				}	
				throw new StormDBException('Adding collection with data (array) is not implemeted. ');
			}
		}

	}


	// Overwrites
	public function __get($name)
	{
		return $this->collection($name);
	}


	/**
	 * __isset() function
	 * Checks if the collection is available.
	 *
	 * @return void
	 **/
	public function __isset($name)
	{
		return isset(array_flip($this->base->collections)[$name]);
	}
}