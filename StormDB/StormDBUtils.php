<?php

class StormDBException extends Exception {}


function buildTree(array $source, $search)
{
	$out=array();
	foreach($source[$search] as $key => $node) {
		if (isset($source[$node])) {
			$out[$key] = buildTree($source, $node);
			unset($source[$node]);
		} else {
			$out[$key] = $node;
		}
	}
	return $out;
}

function assignNames(array $source, array $names)
{
	$result = array();
	foreach ($source as $key => $value) {
		if (is_array($value)) {
			$result[$names[$key]] = assignNames($source[$key], $names);
		} else {
			$result[$names[$key]] = $names[$value];
		}
	}
	return $result;
}