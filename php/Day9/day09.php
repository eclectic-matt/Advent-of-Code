<?php

//ADVENT OF CODE 2022 - DAY 9

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT VISITED ARRAY
$visited = array();
//START POSITION IS VISITED
$visited[] = '0,0';
//TAIL AND HEAD START IN 0,0
$headPos = [0,0];
$tailPos = [0,0];

echo '<pre>';

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		$dir = explode(" ",$line)[0];
		$len = explode(" ",$line)[1];

		//DEBUG
		echo "<b>MOVE $dir BY $len</b><br>";

		//PROCESS EACH STEP
		for($i = 0; $i < $len; $i++){

			//SWITCH DIR
			switch($dir){
				case 'U':
					$xDiff = 0;
					$yDiff = 1;
					/*
					//CHANGE HEAD POSITION
					$headPos = [$headPos[0], ($headPos[1] + 1)];
					echo 'Head is now at: ' . implode(',',$headPos) . '<br>';
					//CHECK FOR TAIL UPDATE (COMPARE X DISTANCE AND Y DISTANCE, IF EITHER > 1 THEN UPDATE)
					if(max($headPos[0] - $tailPos[0], $headPos[1] - $tailPos[1]) > 1){
						//CHANGE TAIL POSITION
						$tailPos = [$tailPos[0], ($tailPos[1] + 1)];
						echo 'TAIL MOVE - now at: ' . implode(',',$tailPos) . '<br>';
						if(!in_array(implode(',',$tailPos),$visited)){
							$visited[] = implode(',',$tailPos);
							echo 'NEW TILE - Visited count is now: ' . count($visited) . '<br>';
						}
					}*/
				break;
				case 'D':
					$xDiff = 0;
					$yDiff = -1;
					/*
					//CHANGE HEAD POSITION
					$headPos = [$headPos[0], ($headPos[1] - 1)];
					echo 'Head is now at: ' . implode(',',$headPos) . '<br>';
					//CHECK FOR TAIL UPDATE (COMPARE X DISTANCE AND Y DISTANCE, IF EITHER > 1 THEN UPDATE)
					if(max($headPos[0] - $tailPos[0], $headPos[1] - $tailPos[1]) > 1){
						//CHANGE TAIL POSITION
						$tailPos = [$tailPos[0], ($tailPos[1] - 1)];
						echo 'TAIL MOVE - now at: ' . implode(',',$tailPos) . '<br>';
						if(!in_array(implode(',',$tailPos),$visited)){
							$visited[] = implode(',',$tailPos);
							echo 'NEW TILE - Visited count is now: ' . count($visited) . '<br>';
						}
					}*/
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
			echo 'HEAD MOVE: ' . implode(',',$headPos) .  ' (distance: ' . max(abs($headPos[0] - $tailPos[0]), abs($headPos[1] - $tailPos[1])) . ')<br>';
			
			switch(true){
				case ( (abs($headPos[0] - $tailPos[0]) <= 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ):
					//echo 'ADJACENT<br>';
				break;

				//X-ONLY DIFF
				case ( (abs($headPos[0] - $tailPos[0]) > 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ):
					//X ONLY
					echo 'X-diff ONLY<br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
					$yDiff = 0;
				break;
				
				//Y-ONLY DIFF
				case ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) <= 1) ):
					//Y ONLY
					echo 'Y-diff ONLY<br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
					$xDiff = 0;
				break;

				//DIAGONAL DIFF
				case ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) > 1) ):
					//DIAGONAL
					echo '<b style="color: blue;">X AND Y-diff</b><br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
					$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
				break;
			}

			//
			$tailPos = [ ($tailPos[0] + $xDiff), ($tailPos[1] + $yDiff) ];
			if( ($xDiff === 0) and ($yDiff === 0) ){
				echo '<b>TAIL STAY: ' . implode(',',$tailPos) . '</b><br>';
			}else{
				echo '<b>TAIL MOVE: ' . implode(',',$tailPos) . '</b><br>';
			}
			
			//CHECK IF THIS TILE HAS BEEN VISITED BEFORE
			if(!in_array(implode(',',$tailPos),$visited)){

				$visited[] = implode(',',$tailPos);
				echo '<b style="color: red;">NEW TILE - Visited count is now: ' . count($visited) . '</b><br>';
			}else{
				echo '<em>TAIL HAS ALREADY VISITED THIS TILE</em><br>';
			}
			echo '<br>';

			/*
			//CHECK FOR TAIL UPDATE (COMPARE X DISTANCE AND Y DISTANCE, IF EITHER > 1 THEN UPDATE)
			if(max(abs($headPos[0] - $tailPos[0]), abs($headPos[1] - $tailPos[1])) > 1){
				
				//THIS ONLY MOVES IN ONE DIRECTION (UP/DOWN/LEFT/RIGHT)
				//THINK THIS *ALSO* NEEDS A DIAGONAL OPTION
				
				//CHANGE TAIL POSITION
				$tailPos = [ ($tailPos[0] + $xDiff), ($tailPos[1] + $yDiff) ];
				echo '<b>TAIL MOVE: ' . implode(',',$tailPos) . '</b><br>';
				
				//CHECK IF THIS TILE HAS BEEN VISITED BEFORE
				if(!in_array(implode(',',$tailPos),$visited)){

					$visited[] = implode(',',$tailPos);
					echo '<b style="color: red;">NEW TILE - Visited count is now: ' . count($visited) . '</b><br>';
				}else{
					echo '<em>TAIL HAS ALREADY VISITED THIS TILE</em><br>';
				}
				echo '<br>';
			}else{
				echo '<em>TAIL STAY: ' . implode(',',$tailPos) . '</em><br>';
			}
			*/
		}

		echo '<hr>';
	}
}

echo '<h1>Total Visited: ' . count($visited) . '</h1>';
echo '<h1>Total Unique Visited: ' . count(array_unique($visited)) . '</h1>';
//60 nope
//6137 too low
//7119 too high

//echo '<pre>';
print_r($visited);
echo '</pre>';