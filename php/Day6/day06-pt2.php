<?php

//ADVENT OF CODE 2022
//DAY 6 - MESSAGE ENCRYPTION - START_OF_MESSAGE

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT INDEX
$index = 0;
//INIT "LAST X CHARACTERS" STRING
$lastChars = '';
//GET THE LAST 14 CHARACTERS
$charLimit = 14;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//SPLIT CHARS INTO ARRAY
		$chars = str_split($line);

		//ITERATE CHAR ARRAY
		foreach($chars as $char){

			//IF WE ARE ONLY JUST STARTING THE STRING
			if(strlen($lastChars) < $charLimit){

				//ADD CHAR TO THE "LAST X"
				$lastChars .= $char;
			}else{

				//TAKE LAST (X - 1) CHARS FROM "LAST X" AND ADD CHAR
				$lastChars = substr($lastChars,1,$charLimit - 1) . $char;

				//SPLIT INTO ARRAY
				$lastCharsArr = str_split($lastChars);

				//CHECK IF ARRAY UNIQUE == LAST FOUR ARRAY
				if(array_unique($lastCharsArr,SORT_STRING) === $lastCharsArr){
				
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