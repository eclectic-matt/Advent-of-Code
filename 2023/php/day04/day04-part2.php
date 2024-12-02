<?php

$input = file_get_contents('input.txt');

$values = array();

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

$totalScore = 0;

foreach($lines as $index => $line){
	$line = preg_replace('/(Card( +)(\d+): )/','',$line);
	//echo $line . '<br>';
	$split = explode('|', $line);
	$winArr = array_filter(explode(' ',$split[0]));
	$curArr = array_filter(explode(' ', $split[1]));
	
	echo '<h2>Game ' . ($index + 1) . '</h2>';
	echo 'Winning: ' . implode(', ', $winArr);
	echo '<br>';
	echo 'Current: ' . implode(', ', $curArr);
	echo '<br>';
	
	$score = 0;
	foreach($curArr as $curNum){
		if(in_array($curNum,$winArr)){
			if($score === 0){
				$score = 1;
			}else{
				$score *= 2;
			}
			echo 'Matched ' . $curNum . ' - current score: ' . $score . '!<br>';
		}
	}
	echo 'Card ' . ($index + 1) . ' wins ' . $score . ' scratchcards - ';
	for($i = 1; $i <= $score; $i++){
		echo ($index + 1) + $i . ', ';
	}
	echo '<br>';
	$totalScore += $score;
	echo 'At the end of game ' . $index . ' - total score: ' . $totalScore . '!<br>';
}

echo 'Total Score: ' . $totalScore . '<br>';
//48531 - too high
//23028 - weiner
