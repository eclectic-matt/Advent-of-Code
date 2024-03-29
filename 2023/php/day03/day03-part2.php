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
				echo '<h2>2 adj nums = ' . $adjNums[0] . ' * ' . $adjNums[1] . ' = ' . ( $adjNums[0] * $adjNums[1] ) . '</h2><br>';	//GEAR FOUND AT (61, 84)
				$values[] = $adjNums[0] * $adjNums[1];
			}else{
				echo 'Not enough adjNums = ' . implode(',', $adjNums) . '<br>';
			}
			//OUTPUT VISUAL DISPLAY FOR THIS GEAR
			outputHighlightGrid($row, $col);
		}
	}
}

//ISSUES
//$values[] = '449 * 4';

echo '<br><hr><br><h1>TOTAL: ' . array_sum($values) . '</h1>';
//13878629 - too low
//39393818 - too low
//84796018 - too high
//20701969 - NOPE
//78269450 - nope 
//78353111 - also nope
//78346458 - still nope
//80715602 - nope nope nope (8th incorrect guess)
//78356951 - nope
//78273022 - nope
//78272573

function outputHighlightGrid($highlightRow, $highlightCol){
	
	global $grid;
	//echo '<h1>Highlighting (' . $highlightRow . ', ' . $highlightCol . ')</h1>';
	echo '<pre>';
	$highlightSize = 3; //ROWS + / - TO DISPLAY
	
	foreach($grid as $row => $rowData){
		if( ($row < ($highlightRow - $highlightSize)) or ($row > ($highlightRow + $highlightSize)) ) continue;
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

function getAdjacentNumbers($grid, $row, $col){
	
	$maxNumLen = 4;
	//THE MAX ROWS
	$rowCount = count($grid);
	//THE MAX COLS
	$colCount = count($grid[$row]);
	//THE ADJACENT "ORDINAL" POINTS TO ITERATE OVER
	$ordinals = array('tm', 'tr', 'rm', 'rb', 'bm', 'bl', 'lm', 'tl' );
	//INIT ADJACENT
	$adjacent = array();
	$adjacentCoords = array();

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
					$thisRow = $row - 1;
					$thisCol = $col + 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'rm':
				//RIGHT - SAME ROW, COL + 1
				if($col < ($colCount - 1)){
					$thisRow = $row;
					$thisCol = $col + 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'rb':
				//BTM RIGHT, ROW + 1, COL + 1
				if( ($row < ($rowCount - 1) ) && ($col < ($colCount - 1)) ){
					$thisRow = $row + 1;
					$thisCol = $col + 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'bm':
				//BTM MID
				if( ($row < ($rowCount - 1))){
					$thisRow = $row + 1;
					$thisCol = $col;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'bl':
				//BTM LEFT (ROW > 0, COL > 0)
				if( ( $row < ($rowCount - 1) ) && ( $col > 0 ) ){
					$thisRow = $row + 1;
					$thisCol = $col - 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'lm':
				//LEFT
				if($col > 0){
					$thisRow = $row;
					$thisCol = $col - 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
			case 'tl':
				//TOP LEFT
				if( ($row > 0) && ($col > 0)) {
					$thisRow = $row - 1;
					$thisCol = $col - 1;
					$val = $grid[$thisRow][$thisCol];
				}
			break;
		}

		//IS THE ADJACENT CELL NUMERIC?
		if(is_numeric($val)){
			$currentNum = '';
			$currentNumStartIndex = 0;
			$currentNumEndIndex = 0;

			//echo '"' . $val . '" is numeric - check from ' . max(0,$thisCol - $maxNumLen) . ' to ' .  min($thisCol + $maxNumLen, $colCount -1) . '<br>';
			for($i = max(0,$thisCol - $maxNumLen); $i < min($thisCol + $maxNumLen, $colCount -1); $i++){
				
				if(is_numeric($grid[$thisRow][$i])){
					if($currentNum === ''){
						//STORE THE COLUMN THIS NUMBER STARTS
						$currentNumStartIndex = $i;
					}
					$currentNum .= $grid[$thisRow][$i];
					//echo $currentNum . ' (' . $thisRow . ', ' . $i . ')<br>';
				}else{
					//echo $grid[$thisRow][$i] . ' is not numeric, current = ' . $currentNum . ' - break here!<br>';
					if(in_array($currentNum, $adjacent)){
						//DO NOT STORE DUPLICATE
					}else{
						//CHECK NUM IS NUMERIC!
						if(is_numeric($currentNum)){
							//STORING NUMBER HERE
							$currentNumEndIndex = $i;
							//CHECK VALID START/END - ONE END SHOULD BE +/- 1 OF $thisCol
							$startDiff = abs($thisCol - $currentNumStartIndex);
							$endDiff = abs($thisCol - $currentNumEndIndex);
							//if( (max($startDiff, $endDiff) > 1) and (min($startDiff, $endDiff) > 1) ){
							if( (max($startDiff, $endDiff) >= $maxNumLen) or (min($startDiff, $endDiff) > 1)){
							//if( ($startDiff > 1) or ($endDiff > 1) ){
								//NUMBER OUTSIDE ADJACENT RANGE
								echo 'The current number "' . $currentNum . '" boundaries (' . $currentNumStartIndex . ', ' . $currentNumEndIndex . ') starts/ends OUTSIDE the adjacent range (' . $startDiff . ', ' . $endDiff . ') - discarding...<br>';
							}else{
								//GEAR FOUND AT (131, 104) 2 adj nums = 648 * 499
								echo 'The current number "' . $currentNum . '" boundaries (' . $currentNumStartIndex . ', ' . $currentNumEndIndex . ') starts/ends inside the adjacent range (' . $startDiff . ', ' . $endDiff . ')<br>';
								/*$matches = false;
								foreach($adjacent as $adj){
									$thisAdj = (string) $adj;
									$strCur = (string) $currentNum;
									echo 'Checking if "' . $strCur . '" is within "' . $thisAdj . '"';
									//if(stripos($adj, $currentNum) !== false){
									if(stripos($thisAdj, $strCur) !== false){
										$matches = true;
										echo ' - yep!<br>';
									}else{
										echo ' - nope<br>';
									}
								}*/
								$currentNumCoords = [ $thisRow, $currentNumStartIndex , $currentNumEndIndex ];
								if(in_array($currentNumCoords, $adjacentCoords)){
								//if($matches){
									//DO NOT STORE - GEAR FOUND AT (47, 32) => adjNums = 247,47,37 => 2 adj nums = 247 * 47
									echo 'The current number "' . $currentNum . '" is within a stored number - discarding...<br>';
								}else{
									//STORE CURRENT NUM
									$adjacent[] = $currentNum;
									$adjacentCoords[] = $currentNumCoords;
								}
							}
						}
					}
					//RESET CURRENT NUM
					$currentNum = '';
				}
			}

			//GEAR FOUND AT (38, 7)


			if(in_array($currentNum, $adjacent)){
				//DO NOT STORE DUPLICATE
			}else{
				//CHECK NUM IS NUMERIC!
				if(is_numeric($currentNum)){
					//STORING NUMBER HERE
					$currentNumEndIndex = $i;
					//CHECK VALID START/END - ONE END SHOULD BE +/- 1 OF $thisCol
					$startDiff = abs($thisCol - $currentNumStartIndex);
					$endDiff = abs($thisCol - $currentNumEndIndex);
					//if( (max($startDiff, $endDiff) > 1) and (min($startDiff, $endDiff) > 1) ){
					if( (max($startDiff, $endDiff) >= $maxNumLen) or (min($startDiff, $endDiff) > 1)){
						//DISCARD NUM GEAR FOUND AT (12, 4) 2 adj nums = 449 * 46
						echo 'The current number "' . $currentNum . '" boundaries (' . $currentNumStartIndex . ', ' . $currentNumEndIndex . ') starts/ends OUTSIDE the adjacent range (' . $startDiff . ', ' . $endDiff . ') - discarding...<br>';
					}else{
						//GEAR FOUND AT (12, 4)
						//2 adj nums = 449 * 4
						if(trim($currentNum) === '') continue;
						/*$matches = false;
						foreach($adjacent as $adj){
							$thisAdj = (string) $adj;
							$strCur = (string) $currentNum;
							echo 'Checking if "' . $strCur . '" is within "' . $thisAdj . '"';
							//if(stripos($adj, $currentNum) !== false){
							if(stripos($thisAdj, $strCur) !== false){
								$matches = true;
								echo ' - yep!<br>';
							}else{
								echo ' - nope<br>';
							}
						}
						if($matches){
							*/
						$currentNumCoords = [ $thisRow, $currentNumStartIndex , $currentNumEndIndex ];
						if(in_array($currentNumCoords, $adjacentCoords)){
							//DO NOT STORE - GEAR FOUND AT (47, 32) => adjNums = 247,47,37 => 2 adj nums = 247 * 47
							echo 'The current number "' . $currentNum . '" is within a stored number - discarding...<br>';
						}else{
							//STORE CURRENT NUM
							$adjacent[] = $currentNum;
							$adjacentCoords[] = $currentNumCoords;
						}
					}
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