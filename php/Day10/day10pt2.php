<?php

//ADVENT OF CODE 2022 - DAY 10, PART 2

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//THE CYCLES TO SUM SIGNAL STRENGTH FOR
$cyclesToCheck = range(20, 260, 40);
//THE CURRENT CYCLE
$cycle = 0;
//THE REGISTER VALUE
$x = 1;
//THE DISPLAY STRING
$display = '';
//THE LENGTH OF EACH LINE
$lineLength = 40;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		$op = substr($line, 0, 4);

		switch($op){
			case 'noop':
				//INCREMENT CYCLE BY 1 (MOD 40)
				$cycle = ($cycle + 1) % $lineLength;
				//echo "ON CYCLE $cycle<br>";

				//IF THIS CYCLE IS WITHIN THE SPRITE WIDTH (+/- 1)
				if(abs($x - $cycle) <= 1){
					//DRAW PIXEL
					$display .= '#';
				}else{
					//DISPLAY BLANK
					$display .= '.';
				}
			break;
			case 'addx':
				//INCREMENT CYCLE BY 1 (MOD 40)
				$cycle = ($cycle + 1) % $lineLength;
				//echo "ON CYCLE $cycle<br>";

				//IF THIS CYCLE IS WITHIN THE SPRITE WIDTH (+/- 1)
				if(abs($x - $cycle) <= 1){
					//DRAW PIXEL
					$display .= '#';
				}else{
					//DISPLAY BLANK
					$display .= '.';
				}
				//INCREMENT CYCLE BY 1 (MOD 40)
				$cycle = ($cycle + 1) % $lineLength;
				//echo "ON CYCLE $cycle<br>";

				//IF THIS CYCLE IS WITHIN THE SPRITE WIDTH (+/- 1)
				if(abs($x - $cycle) <= 1){
					//DRAW PIXEL
					$display .= '#';
				}else{
					//DISPLAY BLANK
					$display .= '.';
				}
				//AFTER THIS CYCLE, INCREMENT THE REGISTER
				$x += intval(explode(" ", $line)[1]);
			break;
		}
	}
}

//OUTPUT ANSWER
echo '<pre>';
//SPLIT INTO LINES OF LENGTH 40
$displayLines = str_split($display,$lineLength);
echo 'COUNT: ' . count($displayLines) . '<br>';
foreach($displayLines as $line){
	echo $line . '<br>';
}
echo '</pre>';