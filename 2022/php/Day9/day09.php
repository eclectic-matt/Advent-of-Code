<?php

//ADVENT OF CODE 2022 - DAY 9

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");
//$handle = fopen("test.txt", "r");

//INIT VISITED ARRAY
$visited = array();
//START POSITION IS VISITED
$visited[] = '0,0';
//INIT HEAD POSITION
$headPos = [0,0];
//INIT TAIL POSITION
$tailPos = [0,0];

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		$dir = explode(" ",$line)[0];
		$len = explode(" ",$line)[1];

		//PROCESS EACH STEP
		for($i = 0; $i < $len; $i++){

			//SWITCH DIR
			switch($dir){
				case 'U':
					$xDiff = 0;
					$yDiff = -1;
				break;
				case 'D':
					$xDiff = 0;
					$yDiff = 1;
				break;
				case 'L':
					$xDiff = -1;
					$yDiff = 0;
				break;
				case 'R':
					$xDiff = 1;
					$yDiff = 0;
				break;
			}

			//CHANGE HEAD POSITION (+/- $xDiff OR $yDiff)
			$headPos = [ ($headPos[0] + $xDiff), ($headPos[1] + $yDiff) ];

			if ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) >= 1) ){
				//DIAGONAL - IF BELOW 0, DIFF IS -1, ELSE +1
				$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
				$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
			}else if ( (abs($headPos[1] - $tailPos[1]) >= 1) and (abs($headPos[0] - $tailPos[0]) > 1) ){
				//DIAGONAL - IF BELOW 0, DIFF IS -1, ELSE +1
				$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
				$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
			}else if ( (abs($headPos[0] - $tailPos[0]) <= 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ){
				//ADJACENT - NO CHANGE
				$xDiff = 0;
				$yDiff = 0;
			}else if ( (abs($headPos[0] - $tailPos[0]) > 1) and (abs($headPos[1] - $tailPos[1]) < 1) ){
				//X ONLY - IF BELOW 0, DIFF IS -1, ELSE +1
				$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
				$yDiff = 0;
			}else if ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) < 1) ){
				//Y ONLY - IF BELOW 0, DIFF IS -1, ELSE +1
				$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
				$xDiff = 0;
			}


			//UPDATE TAIL POSITION
			$tailPos = [ ($tailPos[0] + $xDiff), ($tailPos[1] + $yDiff) ];

			//CHECK IF THIS TILE HAS BEEN VISITED BEFORE
			if(!in_array(implode(',',$tailPos),$visited)){

				$visited[] = implode(',',$tailPos);
			}
		}
	}
}

//OUTPUT ANSWER
echo '<h1>Total Unique Visited: ' . count(array_unique($visited)) . '</h1>';