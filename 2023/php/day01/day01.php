<?php 

$input = file_get_contents("input.txt");

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

//PREPARE AN OUTPUT ARRAY
$values = array();

foreach($lines as $line){
	$split = str_split($line,1);
	$firstDigit = null;
	$lastDigit = null;
	foreach($split as $char){
		if(is_numeric($char)){
			if(is_null($firstDigit)){
				$firstDigit = $char;
				
			}
			$lastDigit = $char;
		}
	}
	$combined = $firstDigit . $lastDigit;
	$values[] = $combined;
}

$total = array_sum($values);
echo $total;
//55621