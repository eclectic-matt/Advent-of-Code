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

//DEBUG HELP
$minX = 1000;
$maxX = -50;
$minY = 1000;
$maxY = -500;

echo '<pre>';
//echo '<b>TAIL STARTS: ' . implode(',',$tailPos) . '</b><br>';
//echo '<hr>';

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		$dir = explode(" ",$line)[0];
		$len = explode(" ",$line)[1];

		//DEBUG
		//echo "<b>MOVE $dir BY $len</b><br>";

		//PROCESS EACH STEP
		for($i = 0; $i < $len; $i++){

			//SWITCH DIR
			switch($dir){
				case 'U':
					$xDiff = 0;
					$yDiff = 1;
				break;
				case 'D':
					$xDiff = 0;
					$yDiff = -1;
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
			//echo 'HEAD MOVE: ' . implode(',',$headPos) .  ' (distance: ' . max(abs($headPos[0] - $tailPos[0]), abs($headPos[1] - $tailPos[1])) . ')<br>';
			
			//DEBUG HELP
			if($headPos[0] < $minX){
				$minX = $headPos[0];
			}
			if($headPos[0] > $maxX){
				$maxX = $headPos[0];
			}
			if($headPos[1] < $minY){
				$minY = $headPos[1];
			}
			if($headPos[1] > $maxY){
				$maxY = $headPos[1];
			}

			switch(true){

				//LESS THAN 1 DIFF - ADJACENT
				case ( (abs($headPos[0] - $tailPos[0]) <= 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ):
					//echo 'ADJACENT<br>';
				break;

				//X-ONLY DIFF
				case ( (abs($headPos[0] - $tailPos[0]) > 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ):
					//X ONLY
					//echo 'X-diff ONLY<br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
					$yDiff = 0;
				break;
				
				//Y-ONLY DIFF
				case ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) <= 1) ):
					//Y ONLY
					//echo 'Y-diff ONLY<br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
					$xDiff = 0;
				break;

				//DIAGONAL DIFF
				case ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) > 1) ):
					//DIAGONAL
					//echo '<b style="color: blue;">X AND Y-diff</b><br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? 1 : -1;
					$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? 1 : -1;
				break;
			}

			//
			$tailPos = [ ($tailPos[0] + $xDiff), ($tailPos[1] + $yDiff) ];
			if( ($xDiff === 0) and ($yDiff === 0) ){
				//echo '<b>TAIL STAY: ' . implode(',',$tailPos) . '</b><br>';
			}else{
				//echo '<b>TAIL MOVE: ' . implode(',',$tailPos) . '</b><br>';
			}
			
			//CHECK IF THIS TILE HAS BEEN VISITED BEFORE
			if(!in_array(implode(',',$tailPos),$visited)){

				$visited[] = implode(',',$tailPos);
				//echo '<b style="color: red;">NEW TILE - Visited count is now: ' . count($visited) . '</b><br>';
			}else{
				//echo '<em>TAIL HAS ALREADY VISITED THIS TILE</em><br>';
			}
			//echo '<br>';
		}

		//echo '<hr>';
	}
}

//echo '<h1>Total Visited: ' . count($visited) . '</h1>';
echo '<h1>Total Unique Visited: ' . count(array_unique($visited)) . '</h1>';
//60 nope
//6137 too low
//7119 too high

//echo '<pre>';
//print_r($visited);


//DEBUGGING LIKE A BASTARD
echo '<style>table{ border: 1px solid blue; border-collapse: collapse; } tr, td { border: 1px solid blue; } </style>';
echo '<table>';
echo '<tr>';
//EMPTY COL (FOR ROW NUMBERS)
echo '<th></th>';

//OUTPUT HEADER ROW - COLUMN NUMBERS 
for($x = $minX; $x < $maxX; $x++){
	echo '<th class="col' . $x . '">' . $x . '</th>';
}
echo '</tr>';

//ITERATE ROWS
for($y = $minY; $y < $maxY; $y++){

	echo '<tr>';
	echo '<td>' . $y . '</td>';
	
	//ITERATE COLUMNS
	for($x = $minX; $x < $maxX; $x++){

		echo '<td title="(' . $y . ', ' . $x . ')" onclick="highlight(' . $y . ', ' . $x . ')" class="row' . $y . ' col' . $x .'">';
		
		//HAS THIS CELL BEEN VISITED?
		if(in_array($x . ',' . $y,$visited)){
			
			//SHOW VISIT # IN THE TABLE CELL
			echo array_keys($visited, $x . ',' . $y)[0];
		}
		echo '</td>';
		
	}
	echo '</tr>';
}
echo '</table>';

//HELPER TO ADD CLICK HIGHLIGHTS
echo '<script>
function highlight(row, col, value){
	console.log("HIGHLIGHT",row,col);
	//RESET STYLE
	for(i = -275; i < 54; i++){
		cells = document.querySelectorAll(".row" + i);
		cells.forEach(cell => {
			cell.style.backgroundColor = "white";
		});
		cells = document.querySelectorAll(".col" + i);
		cells.forEach(cell => {
			cell.style.backgroundColor = "white";
		});
	}
	//APPLY STYLE
	cells = document.querySelectorAll(".row" + row);
	cells.forEach(cell => {
		if(parseInt(cell.innerHTML) >= value){
			cell.style.backgroundColor = "red";
		}else{
			cell.style.backgroundColor = "yellow";
		}
	});
	cells = document.querySelectorAll(".col" + col);
	cells.forEach(cell => {
		if(parseInt(cell.innerHTML) >= value){
			cell.style.backgroundColor = "red";
		}else{
			cell.style.backgroundColor = "yellow";
		}
	});
}
</script>';

/*foreach($visited as $visit){
	$visitX = explode(",",$visit)[0];
	$visitY = explode(",",$visit)[1];

}*/
echo '</pre>';