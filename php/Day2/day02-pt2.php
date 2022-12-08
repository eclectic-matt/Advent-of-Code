<?php

//ADVENT OF CODE 2022
//DAY 2 - PART 2

//INITIALIZE ARRAY
$rules = array();

//OPPONENT PLAYS A = ROCK
$rules['A'] = array(
	'name' => 'rock',	//NAME
	'points' => 1,		//POINTS FOR PLAYING
	'X' => 'C',			//TO LOSE, PLAY THIS SHAPE (ROCK BEATS SCISSORS)
	'Y' => 'A',			//TO DRAW, PLAY THIS SHAPE (THE SAME SHAPE)
	'Z' => 'B'			//TO WIN, PLAY THIS SHAPE (PAPER BEATS ROCK)
);
//OPPONENT PLAYS B = PAPER
$rules['B'] = array(
	'name' => 'paper',
	'points' => 2,
	'X' => 'A',
	'Y' => 'B',
	'Z' => 'C'
);
//OPPONENT PLAYS C = SCISSORS
$rules['C'] = array(
	'name' => 'scissors',
	'points' => 3,
	'X' => 'B',
	'Y' => 'C',
	'Z' => 'A'
);
//LOSS
$rules['X'] = array(
	'name' => 'loss',
	'points' => 0
);
//DRAW
$rules['Y'] = array(
	'name' => 'draw',
	'points' => 3
);
//WIN
$rules['Z'] = array(
	'name' => 'win',
	'points' => 6
);

//INITIALIZE TOTAL
$total = 0;

//OPEN FILE
$handle = fopen("input.txt", "r");

if ($handle) {

	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {
		
		//EXTRACT OPPONENT AND PLAYER'S CHOICES
		$opponent = substr($line, 0, 1);
		$result = substr($line, 2, 1);

		//NEED THE RESULT REQUESTED (e.g. X) 
		//SO LOOK THIS UP AND ADD THE POINTS FOR THE RESULT
		$total += $rules[$result]['points'];
		
		//WILL ACTUALLY BE PLAYING THE CHARACTER RETURNED FROM THE RESULT (e.g. A -> B);
		$char = $rules[$opponent][$result];

		//THEN ADD THE POINTS FOR PLAYING THIS CHARACTER
		$total += $rules[$char]['points'];
	}

	fclose($handle);
}

//OUTPUT ANSWER
echo '<h3>Total: ' . $total . '</h3>';