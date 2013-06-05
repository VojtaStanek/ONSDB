<?php

$filePre = 'StormDB';

$classes = array(
	'Utils',
	'Base',
	'',
	'Collection'
	);


foreach ($classes as $name) {
	require $filePre.$name.'.php';
}