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
		$last = array(-1 => -1);
		$beforeType = 0;

		$data = array();
		$keys = array();

		$file = fopen($this->fileName, 'r');
		$key = 0;
		while (!feof($file)) {
			$value = fgets($file);
			$type = substr($value, 0, 1)*1;
			$data = substr($value, 1, strlen($value)-2);
			$this->types[] = $type;
			$this->data[] = $data;
			$this->parents[$key] = $last[$type-1];
			$this->linesBytes[] = fTell($file);
			
			if($type-1 > $beforeType) {
				$line = $key+1;
				$excMsg = "Incorrect declaration of type in '".$this->database."' line ".$line;
				throw new StormDBException($excMsg, 0);
			}

			if ($type == 0) {
				$this->collections[] = $data;
				
			}

			$last[$type] = $key;
			$beforeType = $type;
			$key++;
		}

		$parentsBuild = array('BASE' => array());

		for ($depth=0; $depth < 10; $depth++) { 
			foreach ($this->types as $key => $type) {
				if ($type == $depth) {
					if($this->parents[$key] >= 0) {
						if(!isset($parentsBuild[$this->parents[$key]]))
							$parentsBuild[$this->parents[$key]] = array();
						$parentsBuild[$this->parents[$key]][$key] = $key;
					} else {
						$parentsBuild['BASE'][$key] = $key;
					}

				}
			}

			

		}

		$this->build = assignNames(buildTree($parentsBuild, 'BASE'), $this->data);
	}


	public function reload($debugMsg = '')
	{
		$this->resetData();
		$this->load();
		$this->debugMsg(array('StormDB reloaded '.$debugMsg => $this));
	}

	public function collection($name)
	{
		if($this->__isset($name)) {
			foreach (array_keys($this->parents, -1) as $key => $value) {
				if ($this->data[$value] = $name) {
					$byte = $this->linesBytes[$value];
					return new StormDBItem($name, 0, $byte, $this);
				}
			}
		}
		return false;
	}

	public function add($data)
	{
	// --DEV
		if (!is_array($data)) {
			$name = $data;
			if (!$this->__isset($name)) {
				$handle = fopen($this->fileName, 'a');
				fwrite($handle, PHP_EOL.'0'.$name);
				fclose($handle);
				$this->reload('add coll. '.$name);
			} else {
				throw new StormDBException("Can't set multiple collections with same name.");
			}
		} else {
			foreach ($data as $name => $value) {
				if ($this->__isset($name)) {
					$handle = fopen($this->fileName, 'a');
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
		return isset(array_flip($this->collections)[$name]);
	}
}