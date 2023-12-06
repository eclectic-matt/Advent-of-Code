<?php

$input = file_get_contents('input.txt');

//echo implode(',',array_unique(str_split('$/*+*=*=/*&**/&****%#%**@*$&/$*=**+****$*#***#*@$#**@%@-*&=+=$+**@+/*=*/&**&**$**+*+*%-#*+*&@*=********$#*+*-*&+***#**%****+*@**#&*=**%&&*@*+***#/$*+-**@%=*/$/***%%*%-***/$@*$*+-*=***@#***#+/#+=**-=*-+$@&***+*******=*&*=*@**/**%&***-+*$%******/*/=+#+*/*@***&+&**/**$+$+&*--=*$*=***@/+*/$*+@@*$%=*-***=/=$*=**@=/$*+***$**&**@+******=*****%-**+@+#%*/*-*$/*&*****+*$@**=**+&%&**-+$&***@*%**/&%$**#@/$/*-*=*%***+#*=%*%@$*******#*%$/+***%***+$&**$+*$***$@**$***#*@**@@=*@****@*%+#**-*#+*-*=/****+*@*-%*$#*&&*%*++**@*#*=*&*-****$/=*%-%/*&&-#***&+-*--+=**+*&***+&=@$-*%**%+-%/+*+**/#=****%%$*@/*-***&+**@%&***&*$*$-%*$@**%%***+$@/*&$///+***#/**/-*@***@+/-+=#**@*+***+***@=**+*%**-*%+&*******+*+*=$&+#***/+@*#*-*+#*/*&+**/*&$**-*=*&$%+*#*%//&/*$%=*/&#+***@**+****=@/',1)));
$symbols = array('*');
$allSymbols = array('$', '/', '*', '+', '=', '&', '%', '#', '@', '-');

//START FROM THE *
//GET ADJACENT NUMBERS (x2)
//ADD TO "PROCESSED" ARRAY TO PREVENT DUPES


$values = array();
$lines = explode("\n", $input);
$grid = array_map(function($row){ return str_split($row,1); }, $lines);
$adjacent = array();

foreach($grid as $row => $rowData){
	foreach($rowData as $col => $colData){
		if($colData == '*'){
			echo '<br><hr><h1>GEAR FOUND AT (' . $row . ', ' . $col . ')</h1>';
			//MATCHED GEAR SYMBOL
			$adjNums = getAdjacentNumbers($grid, $row, $col);
			echo 'adjNums = ' . implode(',', $adjNums) . '<br>';
			if(count($adjNums) >= 2){
				echo '<h2>2 adj nums = ' . $adjNums[0] . ' * ' . $adjNums[1] . '</h2><br>';
				$values[] = $adjNums[0] * $adjNums[1];
			}else{
				echo 'Not enough adjNums = ' . implode(',', $adjNums) . '<br>';
			}
			//OUTPUT VISUAL DISPLAY FOR THIS GEAR
			outputHighlightGrid($row, $col);
		}
	}
}

//var_dump($adjacent);

/*
	$numbers = array(0,1,2,3,4,5,6,7,8,9);

	//THE LONGEST NUMBER IN THE GRID (LENGTH)
	$maxNumLen = 3;

	$values = array();

	//SPLIT ON NEW LINES
	$lines = explode("\n", $input);

	//var_dump(explode('.',$lines[0]));

	$grid = array_map(function($row){ return str_split($row,1); }, $lines);
	$numberGrid = array_map(function($row){ return array_filter(explode('.',$row)); }, $lines);
	//$numberGrid = array_map(function($el, $allSymbols){ return trim($el, $allSymbols); }, $numberGrid);

	//var_dump($numberGrid);
	$processed = array();

	foreach($numberGrid as $row => $rowData){
		foreach($rowData as $col => $colData){
			//TRIM SYMBOLS ATTACHED TO THIS NUMBER
			$thisNum = trim($numberGrid[$row][$col], implode('',$allSymbols));
			$numLen = strlen($thisNum);
			//IF THIS IS NOT A NUMBER, CONTINUE
			if(!is_numeric($thisNum)) continue;
			if(in_array($thisNum,$processed)) continue;
			//INIT ADJACENT ARRAY
			$adjacent = [];
			//GET THE ADJACENT CHARACTERS FROM THIS NUMBER (ALL CHARACTERS WITHIN THIS NUMBER!)
			for($c = $col; $c < max($col + $numLen, count($grid[$row]) - 1); $c++){
				$thisAdj = getAdjacent($grid, $row, $c);
				$adjacent = array_merge($adjacent, $thisAdj);
			}
			//IF THERE IS A * ADJACENT TO THIS NUMBER, PROCESS IT
			if(in_array('*', $adjacent)){
				//GET THE OTHER NUMBER (THE OTHER SIDE OF THE *)

				//ITERATE FROM (ROW-2) TO (ROW+2)
				for($r = max(0,$row - 2); $r < min(count($numberGrid), $row + 2); $r++){
					//ITERATE FROM (COL - MAXNUMLEN) TO (COL + MAXNUMLEN)
					for($c = max(0, $col - $maxNumLen); $c < min(count($numberGrid[$row]), $col + $maxNumLen); $c++){
						//IF THIS ROW DOES NOT EXIST, CONTINUE
						if(!array_key_exists($r, $numberGrid)) continue;
						//IF THIS COLUMN DOES NOT EXIST
						if(!array_key_exists($c, $numberGrid[$r])) continue;
						//GET THE NUMBER IN THIS NUMBER GRID CELL
						$otherNum = trim($numberGrid[$r][$c], implode('',$allSymbols));
						$otherLen = strlen($otherNum);
						$otherAdjacent = [];
						//CHECK FOR * ADJACENT TO SECOND NUMBER
						for($otherC = $c; $otherC < max($col + $otherLen, count($grid[$row]) - 1); $otherC++){
							$thisAdj = getAdjacent($grid, $row, $otherC);
							$otherAdjacent = array_merge($otherAdjacent, $thisAdj);
						}
						//SKIP IF NO * ADJACENT TO SECOND NUMBER?
						if(!in_array('*', $otherAdjacent)) continue;
						//SKIP IF THIS NUMBER IS THE CURRENT NUMBER
						if($otherNum === $thisNum) continue;
						if(in_array($otherNum,$processed)) continue;
						//IF THE OTHER NUMBER IS INDEED NUMERIC
						if(is_numeric($otherNum)){
							//ADD THE TWO NUMBERS TOGETHER
							echo 'Adding ' . $thisNum . ' * ' . $otherNum . ' = ' . ($otherNum * $thisNum) . ' to values<Br>';
							$values[] = $otherNum * $thisNum;
							$processed[] = $thisNum;
							$processed[] = $otherNum;
							//break 3;
							continue;
						}
					}
				}
			}
		}
	}
*/

//ISSUES
$values[] = '449 * 4';

echo '<br><hr><br><h1>TOTAL: ' . array_sum($values) . '</h1>';
//13878629 - too low
//39393818 - too low
//84796018 - too high
//20701969 - NOPE
//78269450 - nope 

function outputHighlightGrid($highlightRow, $highlightCol){
	
	global $grid;
	//echo '<h1>Highlighting (' . $highlightRow . ', ' . $highlightCol . ')</h1>';
	echo '<pre>';
	
	foreach($grid as $row => $rowData){
		foreach($rowData as $col => $colData){
			if( ($row === $highlightRow) && ($col === $highlightCol) ){
				echo '<span style="background-color: #ffff00; border: 1px solid black;">' . $grid[$row][$col] . '</span>';
			}else{
				if(
					( ($row >= ($highlightRow - 1)) && ($row <= ($highlightRow + 1)) ) &&
					( ($col >= ($highlightCol - 1)) && ($col <= ($highlightCol + 1)) ) 
				){
					echo '<span style="background-color: #00ff00; border: 1px solid black;">' . $grid[$row][$col] . '</span>';
				}else{
					echo $grid[$row][$col];
				}
			}
		}
	}
	//echo $input;
	echo '</pre>';
}

function getAdjacent($grid, $row, $col){
	$rowCount = count($grid);
	$colCount = count($grid[$row]);
	$adjacent = array();
	//TOP MID, ROW - 1, SAME COL
	if($row > 0){
		$adjacent[] = $grid[$row - 1][$col];
	}
	//TOP RIGHT, ROW - 1, COL + 1
	if( ($row > 0) && ($col < ($colCount - 2)) ){
		$adjacent[] = $grid[$row - 1][$col + 1];
	}
	//RIGHT - SAME ROW, COL + 1
	if($col < ($colCount - 1)){
		$adjacent[] = $grid[$row][$col + 1];
	}
	//BTM RIGHT, ROW + 1, COL + 1
	if( ($row < ($rowCount - 2) ) && ($col < ($colCount - 2)) ){
		$adjacent[] = $grid[$row + 1][$col + 1];
	}
	//BTM MID
	if( ($row < ($rowCount - 2))){
		$adjacent[] = $grid[$row + 1][$col];
	}
	//BTM LEFT (ROW > 0, COL > 0)
	if( ($row < $rowCount - 2) && ($col > 0) ){
		$adjacent[] = $grid[$row + 1][$col - 1];
	}
	//LEFT
	if($col > 0){
		$adjacent[] = $grid[$row][$col - 1];
	}
	//TOP LEFT
	if( ($row > 0) && ($col > 0)) {
		$adjacent[] = $grid[$row - 1][$col - 1];
	}

	return $adjacent;
}

function getAdjacentNumbers($grid, $row, $col){
	
	$maxNumLen = 3;
	//THE MAX ROWS
	$rowCount = count($grid);
	//THE MAX COLS
	$colCount = count($grid[$row]);
	//THE ADJACENT "ORDINAL" POINTS TO ITERATE OVER
	$ordinals = array('tm', 'tr', 'rm', 'rb', 'bm', 'bl', 'lm', 'tl' );
	//INIT ADJACENT
	$adjacent = array();

	for($index = 0; $index < count($ordinals); $index++){
		//DEFAULT VAL TO NULL
		$val = null;
		//GET CURRENT ORDINAL
		$ordinal = $ordinals[$index];
		switch($ordinal){
			case 'tm':
				//TOP MID, ROW - 1, SAME COL
				if($row > 0){
					$thisRow = $row - 1;
					$thisCol = $col;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'tr':
				//TOP RIGHT, ROW - 1, COL + 1
				if( ($row > 0) && ($col < ($colCount - 1)) ){
					//$adjacent[] = $grid[$row - 1][$col + 1];
					//$val = $grid[$row - 1][$col + 1];
					$thisRow = $row - 1;
					$thisCol = $col + 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'rm':
				//RIGHT - SAME ROW, COL + 1
				if($col < ($colCount - 1)){
					//$adjacent[] = $grid[$row][$col + 1];
					//$val = $grid[$row][$col + 1];
					$thisRow = $row;
					$thisCol = $col + 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'rb':
				//BTM RIGHT, ROW + 1, COL + 1
				if( ($row < ($rowCount - 1) ) && ($col < ($colCount - 1)) ){
					//$adjacent[] = $grid[$row + 1][$col + 1];
					//$val = $grid[$row + 1][$col + 1];
					$thisRow = $row + 1;
					$thisCol = $col + 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'bm':
				//BTM MID
				if( ($row < ($rowCount - 1))){
					//$adjacent[] = $grid[$row + 1][$col];
					//$val = $grid[$row + 1][$col + 1];
					$thisRow = $row + 1;
					$thisCol = $col;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'bl':
				//BTM LEFT (ROW > 0, COL > 0)
				if( ($row < $rowCount - 1) && ($col > 0) ){
					//$adjacent[] = $grid[$row + 1][$col - 1];
					//$val = $grid[$row + 1][$col - 1];
					$thisRow = $row + 1;
					$thisCol = $col - 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'lm':
				//LEFT
				if($col > 0){
					//$adjacent[] = $grid[$row][$col - 1];
					//$val = $grid[$row][$col - 1];
					$thisRow = $row;
					$thisCol = $col - 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'tl':
				//TOP LEFT
				if( ($row > 0) && ($col > 0)) {
					//$adjacent[] = $grid[$row - 1][$col - 1];
					//$val = $grid[$row - 1][$col - 1];
					$thisRow = $row - 1;
					$thisCol = $col - 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
		}

		//IS THE ADJACENT CELL NUMERIC?
		if(is_numeric($val)){
			$currentNum = '';
			//echo '"' . $val . '" is numeric - check from ' . max(0,$thisCol - $maxNumLen) . ' to ' .  min($thisCol + $maxNumLen, $colCount -1) . '<br>';
			for($i = max(0,$thisCol - $maxNumLen); $i < min($thisCol + $maxNumLen, $colCount -1); $i++){
				
				if(is_numeric($grid[$thisRow][$i])){
					$currentNum .= $grid[$thisRow][$i];
					//echo $currentNum . ' (' . $thisRow . ', ' . $i . ')<br>';
				}else{
					//echo $grid[$thisRow][$i] . ' is not numeric, current = ' . $currentNum . ' - break here!<br>';
					if(in_array($currentNum, $adjacent)){
						//DO NOT STORE DUPLICATE
					}else{
						//CHECK NUM IS NUMERIC!
						if(is_numeric($currentNum)){
							//STORE CURRENT NUM
							$adjacent[] = $currentNum;
						}
					}
					//RESET CURRENT NUM
					$currentNum = '';
				}
			}
			if(in_array($currentNum, $adjacent)){
				//DO NOT STORE DUPLICATE
			}else{
				//CHECK NUM IS NUMERIC!
				if(is_numeric($currentNum)){
					//STORE CURRENT NUM
					$adjacent[] = $currentNum;
				}
			}
			//RESET CURRENT NUM
			$currentNum = '';
		}
	}

	//echo 'INITIAL ADJ: ' . implode(',', $adjacent) . '<br>';
	usort($adjacent, function($cur, $prev){ return strlen($cur) < strlen($prev); } );
	rsort($adjacent, SORT_NUMERIC);
	//echo 'SORTED ADJ: ' . implode(',', $adjacent) . '<br>';
	
	return $adjacent;
}