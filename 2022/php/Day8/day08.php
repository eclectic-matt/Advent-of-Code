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
//STORE THE ROW SIZE
$size = $i;

//ITERATE ROWS FROM 1 - (MAX - 1) - IGNORE THE TOP AND BOTTOM ROW
for($row = 1; $row < (count($forest) - 1); $row++){

	//ITERATE COLS FROM 1 TO (MAX - 1) - IGNORE THE LEFT AND RIGHT COLS
	for($col = 1; $col < ($size - 1); $col++){

		//STORE THE TREE HEIGHT
		$thisHeight = $forest[$row][$col];
		//ALTERNATIVE TO TRANSPOSE
		$theCol = array_column($forest,$col);

		$leftMax = $col > 1 ? max(array_slice($forest[$row], 0, $col,true)) : $forest[$row][0];
		$rightMax = $col < 97 ? max(array_slice($forest[$row], $col + 1,99,true)) : $forest[$row][98];
		$upMax = $row > 1 ? max(array_slice($theCol, 0, $row,true)) : $forest[0][$col];
		$downMax = $row < 97 ? max(array_slice($theCol, $row + 1,99,true)) : $forest[98][$col];

		//IF ANY OF THE HEIGHTS ARE ABOVE THE MAX FOR THE LEFT/RIGHT/UP/DOWN
		if(
			//CHECK LEFT - GET THE MAX VALUE IN THIS ROW FROM 0 TO (COL - 1)
			($leftMax < $thisHeight) or
			//CHECK RIGHT - GET THE MAX VALUE IN THIS ROW FROM (COL + 1) TO MAX
			($rightMax < $thisHeight) or 
			//CHECK UP - GET THE MAX VALUE IN THIS COL FROM 0 TO (ROW - 1)
			($upMax < $thisHeight) or
			//CHECK DOWN - GET THE MAX VALUE IN THIS COL FROM (ROW + 1) TO MAX
			($downMax < $thisHeight)
		){
			$totalVisible++;
		}
	}
}

echo '<h1>Total Visible: ' . $totalVisible . '</h1>';