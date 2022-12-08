<?php

//ADVENT OF CODE 2022
//DAY 3

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT TOTAL
$total = 0;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//GET THE MIDPOINT
		$mid = strlen($line) / 2;
		//GET THE FIRST HALF (COMPARTMENT)
		$compOne = substr($line, 0, $mid);
		//GET THE SECOND HALF (COMPARTMENT)
		$compTwo = substr($line, $mid, $mid);
		//SPLIT THESE INTO ARRAYS
		$oneSplit = str_split($compOne);
		$twoSplit = str_split($compTwo);
		//USE ARRAY INTERSECT TO GET MATCHING (ARRAY)
		$matchArr = array_intersect($oneSplit, $twoSplit);
		//USE IMPLODE TO TURN INTO STRING
		$matching = implode('',$matchArr);
		//a - z (97 - 122) subtract 96. A - Z (65 - 90) subtract 38
		$priority = (ord($matching) > 96) ? ord($matching) - 96 : ord($matching) - 38;
		//ADD THIS PRIORITY ONTO THE TOTAL
		$total += $priority;
	}

	fclose($handle);
}

echo '<h3>' . $total . '</h3>';