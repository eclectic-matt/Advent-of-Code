<?php

//TAKE INPUT (REMEMBER TO SAVE THE FILE, RATHER THAN COPY-PASTE LIKE AN EEJIT)
$input = file_get_contents("input.txt");

$total = 0;

$splitByDont = explode('don\'t', $input);
var_dump($splitByDont);

$mulEnabled = true;
foreach($splitByDont as $index => $part){
	if(stripos($part, 'do()') !== false){
		//PROCESS THE PART BEFORE?
	}else{
		//PROCESS THE WHOLE PART
	}
	if($mulEnabled){
		//CARRY OUT INSTRUCTIONS
	}
	$mulEnabled = false;
}
die();

$re = '/mul\((?<mul>\d{1,3})\,(?<operand>\d{1,3})\)/m';
preg_match_all($re, $input, $matches);

//EXTRACT THE BASE AND OPERANDS
$baseMatches = $matches['mul'];
$opMatches = $matches['operand'];


foreach($baseMatches as $index => $match){
	$base = $baseMatches[$index];
	$op = $opMatches[$index];
	$mult = $base * $op;
	$total += $mult;
	echo $matches[0][$index] . ' -> base: ' . $base . ', op: ' . $op . ' == ' . $mult . ' (total=' . $total . ')<br>';
}

echo '<h1>TOTAL: ' . $total . '</h1>';

//225942106 too high (was multiplying $base with $base, duh!)
//184511516 - correct!