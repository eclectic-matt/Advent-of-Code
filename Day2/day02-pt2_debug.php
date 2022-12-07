<?php

//ADVENT OF CODE 2022
//DAY 2 - PART 2

/*

	Rock defeats Scissors, 
	Scissors defeats Paper, and 
	Paper defeats Rock.

	For playing the shape you get: 
		1 for Rock, 
		2 for Paper, and 
		3 for Scissors

	The Elf finishes helping with the tent and sneaks back over to you. 
	"Anyway, the second column says how the round needs to end: 
		X means you need to lose, 
		Y means you need to end the round in a draw, and 
		Z means you need to win. Good luck!"

	The total score is still calculated in the same way, 
	but now you need to figure out what shape to choose so the round ends as indicated. 
	
	The example above now goes like this:

	In the first round, your opponent will choose Rock (A), 
		and you need the round to end in a draw (Y), 
		so you also choose Rock. 
		This gives you a score of 1 + 3 = 4.

	In the second round, your opponent will choose Paper (B), 
		and you choose Rock so you lose (X) 
		with a score of 1 + 0 = 1.

	In the third round, you will defeat your opponent's Scissors 
		with Rock 
		for a score of 1 + 6 = 7.

	Now that you're correctly decrypting the ultra top secret strategy guide, you would get a total score of 12.

	Following the Elf's instructions for the second column, what would your total score be if everything goes exactly according to your strategy guide?
*/

//ROCK 		= A / X (and LOSE)
//PAPER 	= B / Y (and DRAW)
//SCISSORS 	= C / Z (and WIN)
//WIN = Z, DRAW = Y, LOSE = X 

//GUESS (incorrect) = 13755
//GUESS (incorrect) = 13530
//GUESS (incorrect) = 8701
//GUESS (incorrect) = 16648
//GUESS (incorrect) = 12325
//GUESS (incorrect) = 15376

/*
*BEATS*
	ROCK 
	SCISSORS
	PAPER
	ROCK

*LOSES*
	ROCK
	PAPER
	SCISSORS
	ROCK

	$options['A'] = array('name'=>'rock', 'beats'=>'C', 'points'=>1);
	$options['B'] = array('name'=>'paper', 'beats'=>'A', 'points'=>2);
	$options['C'] = array('name'=>'scissors', 'beats'=>'B', 'points'=>3);
*/

//ROCK -beat- SCISSORS -beat- PAPER -beat- ROCK
//ROCK -lose- PAPER -lose- SCISSORS -lose- ROCK
//WIN = Z, 
//DRAW = Y, 
//LOSE = X 

$rules = array();

//OPPONENT PLAYS A = ROCK
$rules['A'] = array(
	'name' => 'rock',	//NAME
	'player' => 'X',	//NAME TO PLAYER (NOT USED)
	'points' => 1,		//POINTS FOR PLAYING
	'X' => 'C',			//TO LOSE, PLAY THIS SHAPE (ROCK BEATS SCISSORS)
	'Y' => 'A',			//TO DRAW, PLAY THIS SHAPE (THE SAME SHAPE)
	'Z' => 'B'			//TO WIN, PLAY THIS SHAPE (PAPER BEATS ROCK)
);
//OPPONENT PLAYS B = PAPER
$rules['B'] = array(
	'name' => 'paper',
	'player' => 'Y',
	'points' => 2,
	'X' => 'A',
	'Y' => 'B',
	'Z' => 'C'
);
//OPPONENT PLAYS C = SCISSORS
$rules['C'] = array(
	'name' => 'scissors',
	'player' => 'Z',
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

//INITIALIZE ARRAY
$total = 0;

//DEBUG THE FUCK OUTTA THIS
echo '<style>';
echo 'table {';
echo '  border: 1px solid black;';
echo '  border-collapse: collapse;';
echo '}';
echo 'tr, th, td {';
	echo '  border: 1px solid black;';
	echo '  border-collapse: collapse;';
	echo '  text-align: center;';
	echo '  paddding: 2px 10px;';
echo '}';
echo '.loss { color: red; }';
echo '.win { color: green; }';
echo '.draw { color: black; }';
echo '</style>';
echo '<table>';
echo '<tr>';
echo '<th>Game</th>';
echo '<th>Opponent</th>';
echo '<th>OpponentShape</th>';
echo '<th>Result</th>';
echo '<th>ResultName</th>';
echo '<th>ResultPoints</th>';
echo '<th>PlayerShape</th>';
echo '<th>ShapeName</th>';
echo '<th>ShapePoints</th>';
echo '<th>Subtotal</th>';
echo '<th>Total</th>';
echo '</tr>';
$index = 0;

//OPEN FILE
$handle = fopen("input.txt", "r");

if ($handle) {

	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {
		
		//EXTRACT OPPONENT AND PLAYER'S CHOICES
		$opponent = substr($line, 0, 1);
		$result = substr($line, 2, 1);

		//DEBUG INDEX
		$index++;
		echo '<tr class="' . $rules[$result]['name'] . '">';
		echo '<td>' . $index . '</td>';
		echo '<td>' . $opponent . '</td>';						//OPPONENT
		echo '<td>' . $rules[$opponent]['name'] . '</td>';		//OPPONENT SHAPE
		echo '<td>' . $result . '</td>';						//RESULT
		echo '<td>' . $rules[$result]['name'] . '</td>';		//RESULT NAME
		echo '<td>' . $rules[$result]['points'] . '</td>';		//RESULT POINTS

		//NEED THE RESULT REQUESTED (e.g. X) 
		//SO LOOK THIS UP AND ADD THE POINTS FOR THE RESULT
		$total += $rules[$result]['points'];
		
		//WILL ACTUALLY BE PLAYING THE CHARACTER RETURNED FROM THE RESULT (e.g. A -> B);
		$char = $rules[$opponent][$result];

		//THEN ADD THE POINTS FOR PLAYING THIS CHARACTER
		$total += $rules[$char]['points'];

		echo '<td>' . $char . '</td>';													//PLAYER SHAPE
		echo '<td>' . $rules[$char]['name'] . '</td>';									//PLAYER SHAPE NAME
		echo '<td>' . $rules[$char]['points'] . '</td>';								//SHAPE POINTS
		echo '<td>' . ($rules[$char]['points'] + $rules[$result]['points']) . '</td>';	//SUBTOTAL
		echo '<td><b>' . $total . '</b></td>';											//TOTAL
		echo '</tr>';

	}

	fclose($handle);
}

echo '</table>';
echo '<h3>Total: ' . $total . '</h3>';