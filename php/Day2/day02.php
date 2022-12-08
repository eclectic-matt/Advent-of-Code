<?php

//ADVENT OF CODE 2022
//DAY 2

/*
	Rock defeats Scissors, Scissors defeats Paper, and Paper defeats Rock.
	The winner of the whole tournament is the player with the highest score. 
	Your total score is the sum of your scores for each round. 
	The score for a single round is the score for the shape you selected 
	(1 for Rock, 2 for Paper, and 3 for Scissors) 
	plus the score for the outcome of the round 
	(0 if you lost, 3 if the round was a draw, and 6 if you won).
*/

//THE CHARACTER THIS RESULT WILL BEAT (SAME = DRAW, OTHERWISE = LOSS)
$beats = array('X' => 'C', 'Y' => 'A', 'Z' => 'B');
$loses = array('X' => 'B', 'Y' => 'C', 'Z' => 'A');
$points = array('X' => 1, 'Y' => 2, 'Z' => 3);

//INITIALIZE ARRAY
$total = 0;

//OPEN FILE
$handle = fopen("input.txt", "r");
if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {
		
		//EXTRACT OPPONENT AND PLAYER'S CHOICES
		$opponent = substr($line, 0, 1);
		$player = substr($line, 2, 1);

		//INCREMENT TOTAL BY THE POINTS FOR THIS CHOICE
		$total += $points[$player];

		//GET THE "BEAT" AND "LOSS" CHARACTERS FOR THIS CHOICE
		$beatChar = $beats[$player];
		$lossChar = $loses[$player];

		//DID THE OPPONENT CHOOSE THE BEATABLE CHAR?
		if($beatChar === $opponent){

			//WIN - 6 POINTS
			$total += 6;
		}elseif($lossChar === $opponent){

			//LOSS - 0 POINTS
			$total += 0;
		}else{

			//DRAW - 3 POINTS
			$total += 3;
		}
	}

	fclose($handle);
}

echo "Total: $total";