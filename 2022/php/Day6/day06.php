<?php

//ADVENT OF CODE 2022
//DAY 6 - MESSAGE ENCRYPTION - START_OF_PACKET

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT INDEX
$index = 0;
//INIT "LAST FOUR CHARACTERS" STRING
$lastFour = '';

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//SPLIT CHARS INTO ARRAY
		$chars = str_split($line);

		//ITERATE CHAR ARRAY
		foreach($chars as $char){

			//IF WE ARE ONLY JUST STARTING THE STRING
			if(strlen($lastFour) < 4){

				//ADD CHAR TO THE "LAST FOUR"
				$lastFour .= $char;
			}else{

				//TAKE LAST 3 CHARS FROM "LAST FOUR" AND ADD CHAR
				$lastFour = substr($lastFour,1,3) . $char;

				//SPLIT INTO ARRAY
				$lastFourArr = str_split($lastFour);

				//CHECK IF ARRAY UNIQUE == LAST FOUR ARRAY
				if(array_unique($lastFourArr,SORT_STRING) === $lastFourArr){
				
					//REACHED UNIQUE CHARS!
					$index += 1;	//ADD 1 (TO THE END OF THE LAST FOUR?)
					echo "<h2>Unique Found at Index $index</h2>";
					//BREAK OUT OF THE FOREACH AND WHILE
					break 2;
				}
			}
			//INCREMENT INDEX AT EACH CHAR
			$index++;
		}
	}

	fclose($handle);
}