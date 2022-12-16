<?php

//ADVENT OF CODE 2022 - DAY 10

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");
//$handle = fopen("test1.txt", "r");

//THE CYCLES TO SUM SIGNAL STRENGTH FOR
//$cyclesToCheck = array( 20, 60, 100, 140, 180, 220 );
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
		//$op = explode(" ", $line)[0];
		echo "<h1>$line</h1>";

		switch($op){
			case 'noop':
				//INCREMENT CYCLE
				$cycle++;
				echo "CYCLE $cycle - NOOP - $x<br>";
				if(in_array($cycle,$cyclesToCheck)){
					$thisSum = $cycle * $x;
					$sum += $thisSum;
					echo "<h2>SUM ON CYCLE $cycle - $thisSum (total: $sum)</h2>";
				}
			break;
			case 'addx':
				//INCREMENT CYCLE BY 1
				$cycle++;
				echo "CYCLE $cycle - addx (1) - $x<br>";
				if(in_array($cycle,$cyclesToCheck)){
					$thisSum = $cycle * $x;
					$sum += $thisSum;
					echo "<h2>SUM ON CYCLE $cycle - $thisSum (total: $sum)</h2>";
				}
				//INCREMENT CYCLE AGAIN
				$cycle++;
				echo "CYCLE $cycle - addx (2) - $x<br>";
				if(in_array($cycle,$cyclesToCheck)){
					$thisSum = $cycle * $x;
					$sum += $thisSum;
					echo "<h2>SUM ON CYCLE $cycle - $thisSum (total: $sum)</h2>";
				}
				//THEN GET THE VALUE TO ADD
				$x += intval(explode(" ", $line)[1]);
				
				echo "END CYCLE $cycle - addx - $x<br>";
				
			break;
		}
	}
}

//OUTPUT ANSWER
echo '<h1>Total Sum: ' . $sum. '</h1>';
//6660 too low
//13940 too high