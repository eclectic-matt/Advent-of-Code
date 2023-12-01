<?php

//ADVENT OF CODE 2022 - DAY 10

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");
//$handle = fopen("test1.txt", "r");

//THE CYCLES TO SUM SIGNAL STRENGTH FOR
$cyclesToCheck = range(20, 260, 40);
//THE CURRENT CYCLE
$cycle = 0;
//THE REGISTER VALUE
$x = 1;
//THE VALUE SUM
$sum = 0;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		$op = substr($line, 0, 4);

		switch($op){
			case 'noop':
				//INCREMENT CYCLE
				$cycle++;
				//IF THIS IS A CYCLE TO SUM ON
				if(in_array($cycle,$cyclesToCheck)){
					$thisSum = $cycle * $x;
					$sum += $thisSum;
				}
			break;
			case 'addx':
				//INCREMENT CYCLE BY 1
				$cycle++;
				//IF THIS IS A CYCLE TO SUM ON
				if(in_array($cycle,$cyclesToCheck)){
					$thisSum = $cycle * $x;
					$sum += $thisSum;
				}
				//INCREMENT CYCLE AGAIN
				$cycle++;
				//IF THIS IS A CYCLE TO SUM ON
				if(in_array($cycle,$cyclesToCheck)){
					$thisSum = $cycle * $x;
					$sum += $thisSum;
				}
				//AFTER THIS CYCLE, INCREMENT THE REGISTER
				$x += intval(explode(" ", $line)[1]);
				
			break;
		}
	}
}

//OUTPUT ANSWER
echo '<h1>Total Sum: ' . $sum. '</h1>';