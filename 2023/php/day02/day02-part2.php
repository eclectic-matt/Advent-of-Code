<?php

$input = file_get_contents('input.txt');

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

//PREPARE AN OUTPUT ARRAY
$cubePowers = array();

//ITERATE OVER EACH LINE
foreach($lines as $line){

	//EXTRACT THE GAME ID
	$gamePattern = '/^Game (\d+):/';
	preg_match($gamePattern, $line,  $matches);
	$gameId = $matches[1];
	if($gameId){
		echo 'Game ID matched as ' . $gameId . ' from "' . $line . '"<br>';
	}
	//PREP RETURN ARRAY
	//$values[$gameId] = array();

	//REMOVE THE GAME ID SECTION FROM THE LINE
	$line = str_ireplace('Game ' . $gameId . ': ', '', $line);
	//EXPLODE THE REST BY ; INTO GAMES
	$games = explode(';', $line);

	//INIT MINIMUM COUNTS
	$minCols = array( 'red' => 0, 'blue' => 0, 'green' => 0);

	//ITERATE GAMES
	foreach($games as $gameIndex => $game){
		//EXPLODE THIS GAME BY , INTO CUBES 
		$cubes = explode(',', $game);
		echo 'Cubes for game ' . $gameId . ' / ' . $gameIndex . ' => ' . implode(',',$cubes) . '<br>';

		
		//ITERATE THROUGH CUBES IN THIS GAME
		foreach($cubes as $cube){
			$cube = trim($cube);
			//echo 'CURRENT CUBE DATA: "' . $cube . '"<br>';
			$cubePattern = '/^(\d+) (\w+)/';
			preg_match($cubePattern, $cube, $cubeMatch);
			if(!isset($cubeMatch[0]) || !isset($cubeMatch[1])) continue;
			$cubeCount = trim($cubeMatch[1]);
			$cubeColour = trim($cubeMatch[2]);

			if($minCols[$cubeColour] < $cubeCount){
				$minCols[$cubeColour] = $cubeCount;
			}
		}

	}

	//STORE THE CUBE POWER
	$cubePowers[] = $minCols['red'] * $minCols['blue'] * $minCols['green'];
}

$gameIdSum = array_sum($cubePowers);
echo 'Cube Powers sum: ' . $gameIdSum . '<br><br>';
//62241 - right first time!