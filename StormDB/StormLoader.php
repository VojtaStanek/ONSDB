<?php
$dir = opendir(dirname(__FILE__));
while ($file = readdir($dir)){
	if($file != '.' && $file != '..' && $file != pathinfo(__FILE__, PATHINFO_BASENAME)) {
		require $file;
	}
}