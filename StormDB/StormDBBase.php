<?php
use Nette\Diagnostics\Debugger;

class StormDBBase
{
	protected $fileName;
	protected $database;
	protected $permission;
	protected $debug = false;

	// Database
	protected $dataFile;
	protected $collections = array();
	protected $types;
	protected $data;
	protected $parents;
	protected $build = array();

	protected function __construct($args)
	{
		$argsNames = array('database', 'path', 'permission', 'debug');
		$a = array_combine($argsNames, $args);

		$this->fileName = $a['path'].$a['database'].'.storm';
		$this->permission = $a['permission'];
		$this->database = $a['database'];
		$this->debug = $a['debug'];
		return $this;
	}

	protected function debugMsg($msg)
	{
		if($this->debug) {
			Debugger::barDump($msg);
		}
	}

	protected function resetData()
	{
		unset($this->dataFile, $this->collections, $this->types, $this->data, $this->parents, $this->build);
		$this->collections = array();
		$this->build = array();
		$this->types = array();
		$this->data = array();
		$this->parents = array();
	}
}