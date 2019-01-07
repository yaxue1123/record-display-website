<?php

	$h = 'photochemcad.com';
	$u = 'jlindsey';
	$p = 'bA9uphEqE=';
	$dbname = 'jlindsey_recorddisplay';
	$mysqli= new mysqli($h,$u,$p,$dbname);
	if ($mysqli->connect_errno) {
		echo "Connect failed" .$mysqli->connect_error;
		exit();
}

?>
