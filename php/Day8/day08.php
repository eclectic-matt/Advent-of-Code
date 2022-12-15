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
echo 'Forest Length: ' . $size . '<br>';
//TRANSPOSE THE ARRAY (https://stackoverflow.com/a/3423692/16384571)
$transposed = array_map(null, ...$forest);

$visibleForest = array();
$visibleForest[0] = array_fill(0,99,1);
$visibleForest[98] = array_fill(0,99,1);

//ITERATE ROWS FROM 1 - (MAX - 1) - IGNORE THE TOP AND BOTTOM ROW
for($row = 1; $row < (count($forest) - 1); $row++){

	$visibleForest[$row] = array();
	$visibleForest[$row][0] = 1;
	$visibleForest[$row][98] = 1;

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

		echo "<h1>CHECK [$row][$col] - HEIGHT: " . $thisHeight . '</h1>';
		echo '<ul>';
		echo '<li>LEFT MAX: ' . $leftMax;
			echo ($leftMax < $thisHeight) ? ' - VISIBLE!</li>' : '</li>';
		echo '<li>RIGHT MAX: ' . $rightMax;
			echo ($rightMax < $thisHeight) ? ' - VISIBLE!</li>' : '</li>';
		echo '<li>UP MAX: ' . $upMax;
			echo ($upMax < $thisHeight) ? ' - VISIBLE!</li>' : '</li>';
		echo '<li>DOWN MAX: ' . $downMax;
			echo ($downMax < $thisHeight) ? ' - VISIBLE!</li>' : '</li>';
		echo '</ul>';


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
			$visibleForest[$row][$col] = 1;
			echo '<h3>Tree at [' . $row . ', ' . $col . '] IS VISIBLE (total: ' . $totalVisible . ')</h3><hr>'; 
		}else{
			$visibleForest[$row][$col] = 0;
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

echo '<pre>';
$spacer = "\t";
$spacer = "&nbsp;";
$spacer = "";
echo '<script>

//HIGHLIGHT PROBLEM CELL
highlight(10,39,6);

function highlight(row, col, value){
	console.log("HIGHLIGHT",row,col);
	//RESET STYLE
	for(i = 0; i < 99; i++){
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

for($row = 0; $row < $size; $row++){
	for($col = 0; $col < $size; $col++){
		echo '<span class="row' . $row . ' col' . $col . '">' . $forest[$row][$col] . '</span>' . $spacer;
	}
	//echo "\t\t\t";
	echo "&nbsp";
	for($col = 0; $col < $size; $col++){
		echo '<span onclick="highlight(' . $row . ', ' . $col . ', ' . $forest[$row][$col] . ')" class="row' . $row . ' col' . $col . '">' . $visibleForest[$row][$col] . '</span>' . $spacer;
	}
	echo "\n";
}
//print_r($forest);
//echo '<hr>';
//print_r($transposed);
//print_r($visibleForest);
echo '</pre>';

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