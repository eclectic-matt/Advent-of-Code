<?php

//ADVENT OF CODE 2022 - DAY 9

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");
//$handle = fopen("test.txt", "r");

//INIT VISITED ARRAY
$visited = array();
//START POSITION IS VISITED
$visited[] = '0,0';

//DEBUG - LOG *EVERY* VISIT
$allVisits = array();
$allVisits[] = '0,0';
//THEN JUST USE array_unique($allVisits)?

//TAIL AND HEAD START IN 0,0
$headPos = [0,0];
$tailPos = [0,0];

//DEBUG HELP
$minX = 1000;
$maxX = -50;
$minY = 1000;
$maxY = -500;


//DEBUGGING LIKE A BASTARD
echo '<style>body { background-color: black; color: white; } table{ border: 1px solid blue; border-collapse: collapse; } tr, td { border: 1px solid blue; width: 15px !important; text-align: center; } </style>';
//HELPER TO ADD CLICK HIGHLIGHTS
echo '<script>
function highlight(row, col, value){
	console.log("HIGHLIGHT",row,col);
	//RESET STYLE
	for(i = -275; i < 54; i++){
		cells = document.querySelectorAll(".row" + i);
		cells.forEach(cell => {
			if(cell.style.backgroundColor === "yellow"){
				cell.style.backgroundColor = "white";
			}
		});
		cells = document.querySelectorAll(".col" + i);
		cells.forEach(cell => {
			if(cell.style.backgroundColor === "yellow"){
				cell.style.backgroundColor = "white";
			}
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
echo '<pre>';
//echo '<b>TAIL STARTS: ' . implode(',',$tailPos) . '</b><br>';
//echo '<hr>';

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		$dir = explode(" ",$line)[0];
		$len = explode(" ",$line)[1];

		//DEBUG
		echo "<b>MOVE $dir BY $len</b><br>";

		//PROCESS EACH STEP
		for($i = 0; $i < $len; $i++){

			echo "<em>Moving $dir by 1</em><br>";
			$prevHead = $headPos;
			$prevTail = $tailPos;

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
			echo 'HEAD MOVES TO: ' . implode(',',$headPos) .  ' (distance: ' . max(abs($headPos[0] - $tailPos[0]), abs($headPos[1] - $tailPos[1])) . ' from ' . implode(',',$tailPos) . ')<br>';
			
			//ALSO STRETCH TO HEAD POS MIN/MAX
			$minX = ($headPos[0] < $minX) ? $headPos[0] : $minX;
			$maxX = ($headPos[0] > $maxX) ? $headPos[0] : $maxX;
			$minY = ($headPos[1] < $minY) ? $headPos[1] : $minY;
			$maxY = ($headPos[1] > $maxY) ? $headPos[1] : $maxY; 

			//echo '<h3>After HEAD</h3>';
			//outputVisitTable($visited, $minX, $maxX, $minY, $maxY, $allVisits, $headPos, $tailPos, $prevHead, $prevTail);

			//DEFAULT IS NO TAIL MOVE
			$xDiff = 0;
			$yDiff = 0;

			/*switch(true){

				//DIAGONAL DIFF
				case ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) > 1) ):
					//DIAGONAL
					echo '<b style="color: blue;">X AND Y-diff</b><br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
					$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
				break;

				//LESS THAN 1 DIFF - ADJACENT
				case ( (abs($headPos[0] - $tailPos[0]) <= 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ):
					echo 'TAIL AND HEAD ARE ADJACENT<br>';
					//$xDiff = 0;
					//$yDiff = 0;
					$xDiff = 0;
					$yDiff = 0;
				break;

				//X-ONLY DIFF
				case ( (abs($headPos[0] - $tailPos[0]) > 1) and (abs($headPos[1] - $tailPos[1]) < 1) ):
					//X ONLY
					echo 'X-diff ONLY<br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
					$yDiff = 0;
				break;
				
				//Y-ONLY DIFF
				case ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) < 1) ):
					//Y ONLY
					echo 'Y-diff ONLY<br>';
					//IF BELOW 0, DIFF IS -1, ELSE +1
					$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
					$xDiff = 0;
				break;
			}*/

			if ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) >= 1) ){
				//DIAGONAL
				echo '<b style="color: blue;">X AND Y-diff</b><br>';
				//IF BELOW 0, DIFF IS -1, ELSE +1
				$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
				$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
			}else if ( (abs($headPos[1] - $tailPos[1]) >= 1) and (abs($headPos[0] - $tailPos[0]) > 1) ){
				//DIAGONAL
				echo '<b style="color: blue;">X AND Y-diff</b><br>';
				//IF BELOW 0, DIFF IS -1, ELSE +1
				$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
				$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
			}else if ( (abs($headPos[0] - $tailPos[0]) <= 1) and (abs($headPos[1] - $tailPos[1]) <= 1) ){
				echo 'TAIL AND HEAD ARE ADJACENT<br>';
				//$xDiff = 0;
				//$yDiff = 0;
				$xDiff = 0;
				$yDiff = 0;
			}else if ( (abs($headPos[0] - $tailPos[0]) > 1) and (abs($headPos[1] - $tailPos[1]) < 1) ){
				//X ONLY
				echo 'X-diff ONLY<br>';
				//IF BELOW 0, DIFF IS -1, ELSE +1
				$xDiff = ($headPos[0] - $tailPos[0]) < 0 ? -1 : 1;
				$yDiff = 0;
			}else if ( (abs($headPos[1] - $tailPos[1]) > 1) and (abs($headPos[0] - $tailPos[0]) < 1) ){
				//Y ONLY
				echo 'Y-diff ONLY<br>';
				//IF BELOW 0, DIFF IS -1, ELSE +1
				$yDiff = ($headPos[1] - $tailPos[1]) < 0 ? -1 : 1;
				$xDiff = 0;
			}


			//
			$tailPos = [ ($tailPos[0] + $xDiff), ($tailPos[1] + $yDiff) ];
			if( ($xDiff === 0) and ($yDiff === 0) ){
				echo '<b>TAIL STAYS AT: ' . implode(',',$tailPos) . '</b><br>';
			}else{
				echo '<b>TAIL MOVES TO: ' . implode(',',$tailPos) . ' (distance: ' . max(abs($headPos[0] - $tailPos[0]), abs($headPos[1] - $tailPos[1])) . ' from ' . implode(',',$headPos) . ')</b><br>';
			}

			//DEBUG HELP
			$minX = ($tailPos[0] < $minX) ? $tailPos[0] : $minX;
			$maxX = ($tailPos[0] > $maxX) ? $tailPos[0] : $maxX;
			$minY = ($tailPos[1] < $minY) ? $tailPos[1] : $minY;
			$maxY = ($tailPos[1] > $maxY) ? $tailPos[1] : $maxY;
			
			$allVisits[] = implode(',',$tailPos);
			//CHECK IF THIS TILE HAS BEEN VISITED BEFORE
			if(!in_array(implode(',',$tailPos),$visited)){

				$visited[] = implode(',',$tailPos);

				//DEBUG
				//echo '<h1>' . $line . ' HEAD ' . implode(',',$headPos) . ' TAIL ' . implode(',',$tailPos) . '</h1>';
				//outputVisitTable($visited, $minX, $maxX, $minY, $maxY, $allVisits, $headPos, $tailPos);
				//echo '<br><hr><br>';
				//echo '<b style="color: red;">NEW TILE - Visited count is now: ' . count($visited) . '</b><br>';
			}else{
				//echo '<em>TAIL HAS ALREADY VISITED THIS TILE</em><br>';
			}


			//echo '<h3>After TAIL</h3>';
			//outputVisitTable($visited, $minX, $maxX, $minY, $maxY, $allVisits, $headPos, $tailPos, $prevHead, $prevTail);
			echo '<br>';
			echo '------------------------';
			echo '<br>';
		}

		echo '<hr>';
	}
}

//echo '<h1>Total Visited: ' . count($visited) . '</h1>';
//echo '<h1>Total Unique Visited: ' . count(array_unique($visited)) . '</h1>';
//echo '<h1>Total Unique Visited: ' . (count($allVisits) - count(array_unique($allVisits))) . '</h1>';
echo '<h1>Total Unique Visited: ' . count(array_unique($allVisits)) . '</h1>';

//60 nope
//6137 too low
//7119 too high

//echo '<pre>';

echo "<ul><li>X = $minX to $maxX</li><li>Y = $minY to $maxY</li></ul>";

outputVisitTable($visited, $minX, $maxX, $minY, $maxY, $allVisits, $headPos, $tailPos, $prevHead, $prevTail);



function outputVisitTable($visited, $minX, $maxX, $minY, $maxY, $allVisits, $headPos, $tailPos, $prevHead, $prevTail){

	echo '<table>';
	echo '<tr>';
	//EMPTY COL (FOR ROW NUMBERS)
	echo '<th></th>';

	//OUTPUT HEADER ROW - COLUMN NUMBERS 
	for($x = $minX; $x <= $maxX; $x++){
		echo '<th class="col' . $x . '">' . $x . '</th>';
	}
	echo '</tr>';

	//ITERATE ROWS
	for($y = $minY; $y <= $maxY; $y++){

		echo '<tr>';
		echo '<td class="row' . $y . '">' . $y . '</td>';
		
		//ITERATE COLUMNS
		for($x = $minX; $x <= $maxX; $x++){

			
			//HAS THIS CELL BEEN VISITED?
			if(in_array($x . ',' . $y,$visited)){

				$allVisitNum = array_keys($allVisits, $x . ',' . $y)[0];
				$allVisitList = implode(",\n",array_keys($allVisits, $x . ',' . $y));

				$visitNum = array_keys($visited, $x . ',' . $y)[0];
				$percent = intval($visitNum) / count($visited);
				$color = number_format(360 * $percent,0,'','');
				$colorStr = 'hsl(' . $color . ', 100%, 50%)';
				//echo '<td style="background-color: ' . $colorStr . '" title="(' . $y . ', ' . $x . ')' . "\n" . $allVisitList . '" onclick="highlight(' . $y . ', ' . $x . ')" class="row' . $y . ' col' . $x .'">';
				echo '<td style="background-color: red;" title="(' . $y . ', ' . $x . ')' . "\n" . $allVisitList . '" onclick="highlight(' . $y . ', ' . $x . ')" class="row' . $y . ' col' . $x .'">';

				//SHOW VISIT # IN THE TABLE CELL
				//echo $visitNum;
				
				//echo $allVisitNum;
				//echo $allVisitList;
				
				/*$visitCount = count(array_filter($allVisits, function($val){
					global $x, $y;
					return $val === $x . ',' . $y;
				}));
				echo $visitCount;
				*/

			}else{

				echo '<td title="(' . $y . ', ' . $x . ')" onclick="highlight(' . $y . ', ' . $x . ')" class="row' . $y . ' col' . $x .'">';
			}

			//OUTPUT start/H current head/T current tail/t previous tail/h previous head
			if( (0 === $x) and (0 === $y) ){ echo 's'; }
			if( ($headPos[0] === $x) and ($headPos[1] === $y) ){ echo 'H'; }
			if( ($tailPos[0] === $x) and ($tailPos[1] === $y) ){ echo 'T'; }
			//if( ($prevHead[0] === $x) and ($prevHead[1] === $y) ){ echo '<small>h</small>'; }
			//if( ($prevTail[0] === $x) and ($prevTail[1] === $y) ){ echo '<small>t</small>'; }

			echo '</td>';
			
		}
		echo '</tr>';
	}
	echo '</table>';
}



/*foreach($visited as $visit){
	$visitX = explode(",",$visit)[0];
	$visitY = explode(",",$visit)[1];

}*/


print_r($allVisits);

echo '</pre>';