<?php

//ADVENT OF CODE 2022 - DAY 8

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT FOREST ARRAY
$forest = array();

$i = 0;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//STORE IN ARRAY AND REMOVE "\n"
		$forest[$i] = array_filter(str_split($line), function($value){
			return str_ireplace("\n","",$value) != "";
		});
		$i++;
	}
}

//FOREACH INTERNAL TREE
//	CHECK LEFT ($forest[$row][0...$i])
//	CHECK RIGHT ($forest[$row][$i + 1 ...$max])
//	CHECK UP ($forest[0...$col][$i])
//	CHECK DOWN ($forest[$col + 1...$max][$i])
//THEN ADD 99 (TOP ROW) + 99 (BOTTOM ROW) + 97 (LEFT COL) + 97 (RIGHT COL)
$totalVisible = 99 + 99 + 97 + 97;

$size = $i;
echo 'Forest Length: ' . $size . '<br>';
$transposed = array_map(null, ...$forest);

//ITERATE ROWS FROM 1 - (MAX - 1) - IGNORE THE TOP AND BOTTOM ROW
for($row = 1; $row < (count($forest) - 1); $row++){

	//ITERATE COLS FROM 1 TO (MAX - 1) - IGNORE THE LEFT AND RIGHT COLS
	for($col = 1; $col < ($size - 1); $col++){

		$thisHeight = $forest[$row][$col];

		echo "<h1>CHECK [$row][$col] - HEIGHT: " . $thisHeight . '</h1>';

		//STORE REFERENCES
		$theRow = $forest[$row];
		$theRow2 = $forest[$row];
		$theCol = $transposed[$col];
		$theCol2 = $transposed[$col];

		//IF ANY OF THE HEIGHTS ARE ABOVE THE MAX FOR THE LEFT/RIGHT/UP/DOWN
		if(
			//CHECK LEFT - GET THE MAX VALUE IN THIS ROW FROM 0 TO (COL - 1)
			(max(array_splice($theRow, 0, max(1, $col - 1))) < $thisHeight) or
			//CHECK RIGHT - GET THE MAX VALUE IN THIS ROW FROM (COL + 1) TO MAX
			(max(array_splice($theRow2, max(1, $col + 1))) < $thisHeight) or 
			//CHECK UP - GET THE MAX VALUE IN THIS COL FROM 0 TO (ROW - 1)
			(max(array_splice($theCol, 0, max(1, $row - 1))) < $thisHeight) or
			//CHECK DOWN - GET THE MAX VALUE IN THIS COL FROM (ROW + 1) TO MAX
			(max(array_splice($theCol2, max(1, $row + 1))) < $thisHeight)
		){
			$totalVisible++;
			echo '<h3>Tree at [' . $row . ', ' . $col . '] IS VISIBLE (total: ' . $totalVisible . ')</h3><hr>'; 
		}else{
			echo '<h3>Tree at [' . $row . ', ' . $col . '] IS NOT VISIBLE</h3><hr>'; 
		}

		/*
		if(
			($maxLeft < $thisHeight) or
			($maxRight < $thisHeight) or
			($maxUp < $thisHeight) or
			($maxDown < $thisHeight)
		){
			$totalVisible++;
			echo '<h3>Tree at [' . $row . ', ' . $col . '] IS VISIBLE (total: ' . $totalVisible . ')</h3><hr>'; 
		}else{
			echo '<h3>Tree at [' . $row . ', ' . $col . '] IS NOT VISIBLE</h3><hr>'; 
		}*/

		/*
		//PASS TO FUNCTION TO CHECK IF VISIBLE IN AT LEAST 1 DIRECTION
		if(checkVisible($forest, $row, $col) === true){

			//DEBUG
			echo 'Tree at [' . $row . ', ' . $col . '] IS VISIBLE<br>'; 
			//INCREMENT THE TOTAL VISIBLE TREE COUNT
			$totalVisible++;
			//break 1;
		}else{

			//DEBUG
			echo 'Tree at [' . $row . ', ' . $col . '] IS NOT VISIBLE<br>'; 
		}
		*/
	}
}

//echo '<hr>';
echo '<h1>Total Visible: ' . $totalVisible . '</h1>';
//490 too low
//2130 too high
//2084 too high
//1980 too many attempts 5min
//2013 too many attempts 5min
//1140 nope
//1286 nope
//1761 nope
//1790


//echo '<pre>';
//print_r($forest);
//echo '<hr>';
//print_r($transposed);
//echo '</pre>';

for($row = 0; $row < 99; $row++){
	for($col = 0; $col < 99; $col++){
		if($forest[$row][$col] !== $transposed[$col][$row]){
			echo "MISMATCH AT [$row][$col]<br>";
		}
	}
}


function checkVisible($forest, $row, $col){

	//THE HEIGHT OF THE CURRENT TREE
	$height = $forest[$row][$col];
	//THE LAST COL
	$maxCol = count($forest[$row]);
	
	$visible = true;
	//CHECK LEFT VISIBLE
	for($i = 0; $i < $col; $i++){
		if($forest[$row][$i] >= $height){
			echo "[$row][$col] IS NOT LEFT VISIBLE DUE TO COL $i WITH HEIGHT " . $forest[$row][$i] . "<br>";
			$visible = false;
			break;
		}
	}
	if($visible){
		echo "[$row][$col] IS LEFT VISIBLE<br>";
		return true;
	}
	//if($visible) return $visible;

	$visible = true;
	//CHECK RIGHT VISIBLE
	for($i = ($col + 1); $i < $maxCol; $i++){
		if($forest[$row][$i] >= $height){
			echo "[$row][$col] IS NOT RIGHT VISIBLE DUE TO COL $i WITH HEIGHT " . $forest[$row][$i] . "<br>";
			$visible = false;
			break;
		}
	}
	if($visible){
		echo "[$row][$col] IS RIGHT VISIBLE<br>";
		return true;
	}
	//if($visible) return $visible;

	$visible = true;
	//CHECK UP VISIBLE
	for($i = 0; $i < $col; $i++){
		if($forest[$i][$col] >= $height){
			echo "[$row][$col] IS NOT UP VISIBLE DUE TO ROW $i WITH HEIGHT " . $forest[$i][$col] . "<br>";
			$visible = false;
			break;
		}
	}
	if($visible){
		echo "[$row][$col] IS UP VISIBLE<br>";
		return true;
	}
	//if($visible) return $visible;

	$visible = true;
	//CHECK DOWN VISIBLE
	for($i = ($col + 1); $i < $maxCol; $i++){
		if($forest[$i][$col] >= $height){
			echo "[$row][$col] IS NOT DOWN VISIBLE DUE TO ROW $i WITH HEIGHT " . $forest[$i][$col] . "<br>";
			$visible = false;
			break;
		}
	}
	if($visible){
		echo "[$row][$col] IS DOWN VISIBLE<br>";
		return true;
	}
	//if($visible) return $visible;

	return false;
}