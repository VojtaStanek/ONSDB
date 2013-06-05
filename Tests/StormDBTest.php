<?php 
require '/var/www/nette/Nette/loader.php';
use Nette\Diagnostics\Debugger;

Debugger::enable(Debugger::DEVELOPMENT);
?>
<h1>StormDB Testing</h1>
<?php
require __DIR__.'/../StormDB/StormLoader.php';


$db = new StormDB('testdb', './../Databases/', 'r+', true);
//$db->add(mt_rand());
/*
$data = array(
		'name' => 'Vojta',
		'mail' => 'blb@blc.cz',
		'pass' => 'Strong pass'
	);

$id[] = $db->collection('collection')->insert($data);

$otherData = array(
		'surname' => 'Novák',
		'telephone' => '908 093 038',
		'address' => 'Street 18, London'
	);
$id[] = $db->collection('collection')->insert($otherData);

$result = $db->collection('collection')->find();

/*
$result = array(
		12345 => array(
			'name' => 'Vojta',
			'mail' => 'blb@blc.cz',
			'pass' => 'Strong pass'
		),
		56789 => array(
			'surname' => 'Novák',
			'telephone' => '908 093 038',
			'address' => 'Street 18, London'
		),
	);

$id = array(
		0 => 12345,  
		1 => 56789
	);


$secondResult = $db->collection('collection')->where(array('id' => $id[1], 'telephone' => '908 093 038'))->find(array('id', 'name', 'address'));
// $secondResult = NULL*/