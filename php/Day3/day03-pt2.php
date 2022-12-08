<?php

//ADVENT OF CODE 2022
//DAY 3

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT TOTAL
$total = 0;
//INIT CURRENT GROUP ARRAY
$group = array();

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//ADD LINE TO THE GROUP
		$group[] = $line;

		//IF WE NOW HAVE 3 LINES
		if(count($group) === 3){

			//PROCESS GROUP - SPLIT INTO CHAR ARRAYS
			$oneSplit = str_split($group[0]);
			$twoSplit = str_split($group[1]);
			$threeSplit = str_split($group[2]);
			//USE ARRAY INTERSECT TO GET MATCHING (ARRAY)
			$matchArr = array_intersect($oneSplit, $twoSplit, $threeSplit);
			//IMPLODE TO CHAR
			$matching = implode('',$matchArr);
			//a - z (97 - 122) subtract 96. A - Z (65 - 90) subtract 38
			$priority = (ord($matching) > 96) ? ord($matching) - 96 : ord($matching) - 38;
			//ADD THIS PRIORITY ONTO THE TOTAL
			$total += $priority;
			//CLEAR GROUP
			$group = array();
		}
	}

	fclose($handle);
}
//OUTPUT ANSWER
echo '<h3>' . $total . '</h3>';