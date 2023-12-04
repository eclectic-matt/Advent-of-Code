<?php

$input = file_get_contents('input.txt');

//echo implode(',',array_unique(str_split('$/*+*=*=/*&**/&****%#%**@*$&/$*=**+****$*#***#*@$#**@%@-*&=+=$+**@+/*=*/&**&**$**+*+*%-#*+*&@*=********$#*+*-*&+***#**%****+*@**#&*=**%&&*@*+***#/$*+-**@%=*/$/***%%*%-***/$@*$*+-*=***@#***#+/#+=**-=*-+$@&***+*******=*&*=*@**/**%&***-+*$%******/*/=+#+*/*@***&+&**/**$+$+&*--=*$*=***@/+*/$*+@@*$%=*-***=/=$*=**@=/$*+***$**&**@+******=*****%-**+@+#%*/*-*$/*&*****+*$@**=**+&%&**-+$&***@*%**/&%$**#@/$/*-*=*%***+#*=%*%@$*******#*%$/+***%***+$&**$+*$***$@**$***#*@**@@=*@****@*%+#**-*#+*-*=/****+*@*-%*$#*&&*%*++**@*#*=*&*-****$/=*%-%/*&&-#***&+-*--+=**+*&***+&=@$-*%**%+-%/+*+**/#=****%%$*@/*-***&+**@%&***&*$*$-%*$@**%%***+$@/*&$///+***#/**/-*@***@+/-+=#**@*+***+***@=**+*%**-*%+&*******+*+*=$&+#***/+@*#*-*+#*/*&+**/*&$**-*=*&$%+*#*%//&/*$%=*/&#+***@**+****=@/',1)));
$symbols = array('*');
$allSymbols = array('$', '/', '*', '+', '=', '&', '%', '#', '@', '-');


$numbers = array(0,1,2,3,4,5,6,7,8,9);

//THE LONGEST NUMBER IN THE GRID (LENGTH)
$maxNumLen = 5;

$values = array();

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

//var_dump(explode('.',$lines[0]));

$grid = array_map(function($row){ return str_split($row,1); }, $lines);
$numberGrid = array_map(function($row){ return array_filter(explode('.',$row)); }, $lines);
//$numberGrid = array_map(function($el, $allSymbols){ return trim($el, $allSymbols); }, $numberGrid);

//var_dump($numberGrid);

foreach($numberGrid as $row => $rowData){
	foreach($rowData as $col => $colData){
		//TRIM SYMBOLS ATTACHED TO THIS NUMBER
		$thisNum = trim($numberGrid[$row][$col], implode('',$allSymbols));
		//IF THIS IS NOT A NUMBER, CONTINUE
		if(!is_numeric($thisNum)) continue;
		$adjacent = getAdjacent($grid, $row, $col);
		if(in_array('*', $adjacent)){
			//GEAR RATIO
			for($r = max(0,$row - 1); $r < min(count($numberGrid), $row + 1); $r++){
				for($c = max(0, $col - $maxNumLen); $c < min(count($numberGrid[$row]), $col + $maxNumLen); $c++){
					if(!array_key_exists($r, $numberGrid)) continue;
					if(!array_key_exists($c, $numberGrid[$r])) continue;
					$otherNum = trim($numberGrid[$r][$c], implode('',$allSymbols));
					if($otherNum === $thisNum) continue;
					if(is_numeric($otherNum)){
						echo 'Adding ' . $thisNum . ' * ' . $otherNum . ' = ' . ($otherNum * $thisNum) . ' to values<Br>';
						$values[] = $otherNum * $thisNum;
						//break 3;
						continue;
					}
				}
			}
		}
	}
}

echo array_sum($values);
//13878629 - too low
//11354558

function getAdjacent($grid, $row, $col){
	$rowCount = count($grid);
	$colCount = count($grid[$row]);
	$adjacent = array();
	//TOP MID, ROW - 1, SAME COL
	if($row > 0){
		$adjacent[] = $grid[$row - 1][$col];
	}
	//TOP RIGHT, ROW - 1, COL + 1
	if( ($row > 0) && ($col < ($colCount - 1)) ){
		$adjacent[] = $grid[$row - 1][$col + 1];
	}
	//RIGHT - SAME ROW, COL + 1
	if($col < ($colCount - 1)){
		$adjacent[] = $grid[$row][$col + 1];
	}
	//BTM RIGHT, ROW + 1, COL + 1
	if( ($row < ($rowCount - 1) ) && ($col < ($colCount - 1)) ){
		$adjacent[] = $grid[$row + 1][$col + 1];
	}
	//BTM MID
	if( ($row < ($rowCount - 1))){
		$adjacent[] = $grid[$row + 1][$col];
	}
	//BTM LEFT (ROW > 0, COL > 0)
	if( ($row < $rowCount - 1) && ($col > 0) ){
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
	
	global $maxNumLen;
	$rowCount = count($grid);
	$colCount = count($grid[$row]);
	$adjacent = array();
	//TOP MID, ROW - 1, SAME COL
	if($row > 0){
		$val = $grid[$row - 1][$col];
		if(is_numeric($val)){
			$currentNum = '';
			for($i = max($col - $maxNumLen); $i < min($col + $maxNumLen, $colCount -1); $i++){
				if(is_numeric($grid[$row][$i])){
					$currentNum .= $grid[$row][$i];
				}else{
					//STORE CURRENT NUM
					$adjacent[] = $currentNum;
				}
			}
		}
	}
	//TOP RIGHT, ROW - 1, COL + 1
	if( ($row > 0) && ($col < ($colCount - 1)) ){
		//$adjacent[] = $grid[$row - 1][$col + 1];
		$val = $grid[$row - 1][$col + 1];
		if(is_numeric($val)){
			$currentNum = '';
			for($i = max(0,$col - $maxNumLen); $i < min($col + $maxNumLen, $colCount -1); $i++){
				if(is_numeric($grid[$row - 1][$i])){
					$currentNum .= $grid[$row][$i];
				}else{
					//STORE CURRENT NUM
					$adjacent[] = $currentNum;
				}
			}
		}
	}
	//RIGHT - SAME ROW, COL + 1
	if($col < ($colCount - 1)){
		//$adjacent[] = $grid[$row][$col + 1];
		$val = $grid[$row][$col + 1];
		if(is_numeric($val)){
			$currentNum = '';
			for($i = max(0,$col - $maxNumLen); $i < min($col + $maxNumLen, $colCount -1); $i++){
				if(is_numeric($grid[$row][$i])){
					$currentNum .= $grid[$row][$i];
				}else{
					//STORE CURRENT NUM
					$adjacent[] = $currentNum;
				}
			}
		}
	}
	//BTM RIGHT, ROW + 1, COL + 1
	if( ($row < ($rowCount - 1) ) && ($col < ($colCount - 1)) ){
		$adjacent[] = $grid[$row + 1][$col + 1];
	}
	//BTM MID
	if( ($row < ($rowCount - 1))){
		$adjacent[] = $grid[$row + 1][$col];
	}
	//BTM LEFT (ROW > 0, COL > 0)
	if( ($row < $rowCount - 1) && ($col > 0) ){
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