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
