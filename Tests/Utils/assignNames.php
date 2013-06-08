<?php
require '../../StormDB/StormDBUtils.php';

$source = array(
	1 => array(
		2 => array(3 => 3),
		4 => array(5 => 5)),
	6 => array(7 => 7)
	);

$names = array(
	1 => 'One',
	2 => 'Two',
	3 => 'Three',
	4 => 'Four',
	5 => 'Five',
	6 => 'Six',
	7 => 'Seven');

$result = assignNames($source, $names);

var_dump($result);