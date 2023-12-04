<?php

$input = file_get_contents('input.txt');

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

//PREPARE AN OUTPUT ARRAY
$validIds = array();

$limits = array(
	'red' => 12,
	'green' => 13,
	'blue' => 14
);

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
	$gameValid = true;
	$currentData = array();

	//ITERATE GAMES
	foreach($games as $gameIndex => $game){
		//EXPLODE THIS GAME BY , INTO CUBES 
		$cubes = explode(',', $game);
		echo 'Cubes for game ' . $gameId . ' / ' . $gameIndex . ' => ' . implode(',',$cubes) . '<br>';
		//ITERATE THROUGH CUBES IN THIS GAME
		foreach($cubes as $cube){
			$cube = trim($cube);
			echo 'CURRENT CUBE DATA: "' . $cube . '"<br>';
			$cubePattern = '/^(\d+) (\w+)/';
			preg_match($cubePattern, $cube, $cubeMatch);
			if(!isset($cubeMatch[0]) || !isset($cubeMatch[1])) continue;
			$cubeCount = trim($cubeMatch[1]);
			$cubeColour = trim($cubeMatch[2]);
			$colLimit = $limits[$cubeColour];
			echo 'Checking ' . $cubeColour . ' = ' . $cubeCount . ' (limit ' . $colLimit . ')<br>';
			if($cubeCount > $colLimit){
				$gameValid = false;
				//DO NOT ADD TO VALID VALUES
				echo 'ABOVE LIMIT - INVALID<br>';
			}else{
				//ADD TO VALID VALUES
				echo 'WITHIN CUBE LIMIT<br>';
				//$values[$gameId][$gameIndex] = [ $cubeColour => $cubeCount ];
				//$currentData[] = [ $cubeColour => $cubeCount ];
			}
		}
	}

	if($gameValid){
		$validIds[] = $gameId;
	}
}

$gameIdSum = array_sum($validIds);
echo 'Game IDs sum: ' . $gameIdSum . '<br><br>';
//5050 too high
//2207 - correct

//var_dump($values);
/*
foreach($values as $value){
	echo implode(',', $value);
}*/