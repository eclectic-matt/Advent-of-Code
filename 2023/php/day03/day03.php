<?php

$input = file_get_contents('input.txt');

//echo implode(',',array_unique(str_split('$/*+*=*=/*&**/&****%#%**@*$&/$*=**+****$*#***#*@$#**@%@-*&=+=$+**@+/*=*/&**&**$**+*+*%-#*+*&@*=********$#*+*-*&+***#**%****+*@**#&*=**%&&*@*+***#/$*+-**@%=*/$/***%%*%-***/$@*$*+-*=***@#***#+/#+=**-=*-+$@&***+*******=*&*=*@**/**%&***-+*$%******/*/=+#+*/*@***&+&**/**$+$+&*--=*$*=***@/+*/$*+@@*$%=*-***=/=$*=**@=/$*+***$**&**@+******=*****%-**+@+#%*/*-*$/*&*****+*$@**=**+&%&**-+$&***@*%**/&%$**#@/$/*-*=*%***+#*=%*%@$*******#*%$/+***%***+$&**$+*$***$@**$***#*@**@@=*@****@*%+#**-*#+*-*=/****+*@*-%*$#*&&*%*++**@*#*=*&*-****$/=*%-%/*&&-#***&+-*--+=**+*&***+&=@$-*%**%+-%/+*+**/#=****%%$*@/*-***&+**@%&***&*$*$-%*$@**%%***+$@/*&$///+***#/**/-*@***@+/-+=#**@*+***+***@=**+*%**-*%+&*******+*+*=$&+#***/+@*#*-*+#*/*&+**/*&$**-*=*&$%+*#*%//&/*$%=*/&#+***@**+****=@/',1)));
$symbols = array('$', '/', '*', '+', '=', '&', '%', '#', '@', '-');

$values = array();

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

$grid = array_map(function($row){ return str_split($row,1); }, $lines);

foreach($grid as $row => $rowData){
	//NUMBERS ARE MULTI-DIGIT BUT ALL ON ONE ROW - STORE 
	$currentNumber = '';
	foreach($rowData as $col => $char){

		//IF THIS CHARACTER IS NUMERIC
		if(is_numeric($char)){
			//ADD TO CURRENT NUMBER
			$currentNumber .= $char;
		}else{
			//CURRENT CHARACTER IS NOT NUMERIC - PROCESS PREVIOUS NUMBER
			if($currentNumber !== ''){
				$adjacent = [];
				//ITERATE FROM START OF CURRENT NUMBER (COL - LEN) UP TO CURRENT COL
				for($i = $col - strlen($currentNumber); $i < $col; $i++){
					//MERGE THE ADJACENT ARRAYS INTO ONE LARGE ARRAY
					$adjacent = array_merge($adjacent, getAdjacent($grid, $row, $i));
				}
				//IF ANY ADJACENT SYMBOLS MATCH
				if(count(array_intersect($symbols, $adjacent)) > 0){
					//VALID - STORE IN VALUES ARRAY
					$values[] = $currentNumber;
					//RESET CURRENT NUMBER TO PROCESS NEXT ON THIS ROW
					$currentNumber = '';
				}else{
					//NOT VALID - DISCARD THE CURRENT NUMBER
					$currentNumber = '';
				}
			}
		}
	}
}

echo array_sum($values);
//7916 - too low
//536202 - correct 

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