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

//STORE THE ROW SIZE
$size = $i;
//THE MAXIMUM VISIBLE TREE COUNT
$maxVisible = 0;

//ITERATE ROWS FROM 1 - (MAX - 1) - IGNORE THE TOP AND BOTTOM ROW
for($row = 1; $row < (count($forest) - 1); $row++){

	//ITERATE COLS FROM 1 TO (MAX - 1) - IGNORE THE LEFT AND RIGHT COLS
	for($col = 1; $col < ($size - 1); $col++){

		//STORE THE TREE HEIGHT
		$thisHeight = $forest[$row][$col];
		//ALTERNATIVE TO TRANSPOSE
		$theCol = array_column($forest,$col);
		
		//DEBUG
		echo "<h1>CHECK [$row][$col] = $thisHeight</h1>";
		echo '<ul>';

		//WALK LEFT (COL = i ... 0)
		$leftVisible = 0;
		for($i = ($col - 1); $i >= 0; $i--){
			echo "<li>Checking column $i = " . $forest[$row][$i] . "</li>";
			$leftVisible++;
			if($forest[$row][$i] >= $thisHeight){
				break;
			}
		}
		echo "<li>LEFT VISIBLE: $leftVisible</li>";

		//WALK RIGHT (COL = i ... MAX)
		$rightVisible = 0;
		for($i = ($col + 1); $i < $size; $i++){
			echo "<li>Checking column $i = " . $forest[$row][$i] . "</li>";
			$rightVisible++;
			if($forest[$row][$i] >= $thisHeight){
				break;
			}
		}
		echo "<li>RIGHT VISIBLE: $rightVisible</li>";

		//WALK UP (ROW = i ... 0)
		$upVisible = 0;
		for($i = ($row - 1); $i >= 0; $i--){
			echo "<li>Checking row $i = " . $forest[$i][$col] . "</li>";
			$upVisible++;
			if($forest[$i][$col] >= $thisHeight){
				//FOUND TALLER TREE - BREAK
				break;
			}
		}
		echo "<li>UP VISIBLE: $upVisible</li>";
		
		//DOWN VISIBLE (ROW = i ... MAX)
		$downVisible = 0;
		for($i = ($row + 1); $i < $size; $i++){
			echo "<li>Checking row $i = " . $forest[$i][$col] . "</li>";
			$downVisible++;
			if($forest[$i][$col] >= $thisHeight){
				break;
			}
		}
		echo "<li>DOWN VISIBLE: $downVisible</li>";

		$thisVisible = ($leftVisible * $rightVisible * $upVisible * $downVisible);
		echo "<li>VISIBLE SCORE: $thisVisible</li>";
		if($thisVisible > $maxVisible){
			echo "<li><b style='color:red'>NEW MAXIMUM AS $thisVisible IS GREATER THAN $maxVisible</b></li>";
			$maxVisible = $thisVisible;
		}

		echo '</ul>';
	}
}

echo '<h1>Max Visible: ' . $maxVisible . '</h1>';