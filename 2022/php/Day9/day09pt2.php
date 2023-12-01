<?php

//ADVENT OF CODE 2022 - DAY 9, PART 2

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");
//$handle = fopen("test.txt", "r");

//INIT VISITED ARRAY
$visited = array();
//START POSITION IS VISITED
$visited[] = '0,0';

//CREATE AN ARRAY (10 ELEMENTS) WHICH ARE ALL [0,0]
$bodyPos = array_fill(0,10,[0,0]);
//THE HEAD POSITION IS NOW $bodyPos[0]
//THE TAIL (#9) IS NOW $bodyPos[9]

//WILL NEED TO PROCESS EACH MOVE FOR *EACH* "JOINT" IN THE BODY

/*
print_r($bodyPos);
$headPos = &$bodyPos[0];
$headPos[0] = 'X';
echo '<br><hr><br>';
print_r($bodyPos);
die();
*/


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

			//MAKE REFERENCE TO THE HEAD POSITION WITHIN THE BODY
			$headPos = &$bodyPos[0];

			//CHANGE HEAD POSITION (+/- $xDiff OR $yDiff)
			//$headPos = [ ($headPos[0] + $xDiff), ($headPos[1] + $yDiff) ];
			$headPos = [ ($headPos[0] + $xDiff), ($headPos[1] + $yDiff) ];

			//PROCESS EACH MOVE
			for($joint = 1; $joint < count($bodyPos); $joint++){

				//MAKE REFERENCE TO THE CURRENT "HEAD" AND "TAIL"
				$currentHead = &$bodyPos[$joint - 1];
				$currentTail = &$bodyPos[$joint];

				if ( (abs($currentHead[1] - $currentTail[1]) > 1) and (abs($currentHead[0] - $currentTail[0]) >= 1) ){
					//DIAGONAL - IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($currentHead[0] - $currentTail[0]) < 0 ? -1 : 1;
					$yDiff = ($currentHead[1] - $currentTail[1]) < 0 ? -1 : 1;
				}else if ( (abs($currentHead[1] - $currentTail[1]) >= 1) and (abs($currentHead[0] - $currentTail[0]) > 1) ){
					//DIAGONAL - IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($currentHead[0] - $currentTail[0]) < 0 ? -1 : 1;
					$yDiff = ($currentHead[1] - $currentTail[1]) < 0 ? -1 : 1;
				}else if ( (abs($currentHead[0] - $currentTail[0]) <= 1) and (abs($currentHead[1] - $currentTail[1]) <= 1) ){
					//ADJACENT - NO CHANGE
					$xDiff = 0;
					$yDiff = 0;
				}else if ( (abs($currentHead[0] - $currentTail[0]) > 1) and (abs($currentHead[1] - $currentTail[1]) < 1) ){
					//X ONLY - IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($currentHead[0] - $currentTail[0]) < 0 ? -1 : 1;
					$yDiff = 0;
				}else if ( (abs($currentHead[1] - $currentTail[1]) > 1) and (abs($currentHead[0] - $currentTail[0]) < 1) ){
					//Y ONLY - IF BELOW 0, DIFF IS -1, ELSE +1
					$yDiff = ($currentHead[1] - $currentTail[1]) < 0 ? -1 : 1;
					$xDiff = 0;
				}
				$currentTail = [ ($currentTail[0] + $xDiff), ($currentTail[1] + $yDiff) ];
			}

			//CHECK AND STORE LAST TAIL POSTITION
			$endTail = &$bodyPos[9];

			//CHECK IF THIS TILE HAS BEEN VISITED BEFORE
			if(!in_array(implode(',',$endTail),$visited)){

				$visited[] = implode(',',$endTail);
			}
		}
	}
}

//OUTPUT ANSWER
echo '<h1>Total Unique Visited: ' . count(array_unique($visited)) . '</h1>';

echo '<pre>';

print_r ($visited);

echo '</pre>';