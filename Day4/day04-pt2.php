<?php

//ADVENT OF CODE 2022
//DAY 4 - PART 2

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT TOTAL
$total = 0;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//GET THE FIRST ASSIGNMENT (FIND ,)
		$firstElf = substr($line, 0, strpos($line,','));
		$secondElf = substr($line, strpos($line,',') + 1);
		//GET MIN/MAXES
		$firstMin = substr($firstElf, 0, strpos($firstElf, '-'));
		$firstMax = substr($firstElf, strpos($firstElf, '-') + 1);
		$secondMin = substr($secondElf, 0, strpos($secondElf, '-'));
		$secondMax = substr($secondElf, strpos($secondElf, '-') + 1);
		//GET THE RANGES
		$firstRange = range($firstMin, $firstMax);
		$secondRange = range($secondMin, $secondMax);
		//GET THE MATCHING VALUES
		$matching = array_intersect($firstRange, $secondRange);

		//IF THERE ARE OVERLAPPING VALUES
		if(count($matching) > 0){
		
				//INCREMENT TOTAL
				$total++;
		}
	}

	fclose($handle);
}

echo '<h3>' . $total . '</h3>';