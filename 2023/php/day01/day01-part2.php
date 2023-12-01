<?php 

//GET THE FILE
$input = file_get_contents("input.txt");

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

//PREPARE AN OUTPUT ARRAY
$values = array();
$words = array(1=>'one', 2=>'two', 3=>'three', 4=>'four', 5=>'five', 6=>'six', 7=>'seven', 8=>'eight', 9=>'nine' );

//ITERATE OVER LINES
foreach($lines as $line){

	//INIT LINE WORDS ARRAY
	$lineWords = array();

	//echo '<h1>' . $line . '</h1>';

	//ITERATE THROUGH EACH AS (ACTUAL DIGIT) => (STRING DIGIT)
	foreach($words as $wordIndex => $wordString){

		//CHECK AT EACH POSITION WITHIN THE LINE
		for($i = 0; $i < strlen($line); $i++){

			//GET THE STRING POSITION OF THIS WORD WITHIN THE STRING (STORED AS INDEX + $i)
			$index = strpos(substr($line,$i), $wordString);
			
			//IF THE WORD DIGIT WAS FOUND WITHIN THIS LINE
			if($index !== false){
				//echo $wordString . ' found at position ' . ($index + $i) . '<br>';
				//STORE WITHIN THE LINE WORDS ARRAY (WORD FOUND AT POSITION $index + $i, DIGIT ITSELF IS WORDINDEX)
				$lineWords[($index + $i)] = $wordIndex;
			}
		}
		
	}
	//echo 'LineWords = ' . implode(',', $lineWords) . '<br>';

	//THEN SPLIT THE LINE
	$split = str_split($line,1);
	$index = 0;
	//ITERATE THROUGH CHARS LOOKING FOR SINGLE DIGITS
	foreach($split as $char){
		//IF THIS CHARACTER IS NUMERIC
		if(is_numeric($char)){
			//STORE THIS CHAR AT INDEX IN THE LINE WORDS ARRAY
			$lineWords[$index] = $char;
			//echo $char . ' found at position ' . $index . '<br>';
		}
		//INCREMENT INDEX
		$index++;
	}

	//SORT THE LINE WORDS ARRAY BY KEYS (POSITION WITHIN LINE)
	ksort($lineWords,SORT_NUMERIC);
	//GET THE FIRST ELEMENT OF THIS ARRAY
	$firstDigit = array_shift($lineWords);
	//GET THE LAST ELEMENT OF THIS ARRAY
	$lastDigit = array_pop($lineWords);
	//IF THERE WAS NO LAST DIGIT
	if(is_null($lastDigit)){
		//STORE THE FIRST DIGIT AS THE LAST DIGIT (DUPLICATED)
		$lastDigit = $firstDigit;
	}
	//JOIN THE FIRST AND LAST DIGITS
	$combined = $firstDigit . $lastDigit;

	echo '=====================================<br>';
	//echo 'LineWords = ' . implode(',', $lineWords) . '<br>';
	foreach($lineWords as $index => $digit){
		echo 'LineWords ' . $index . ' = ' . $digit . '<br>';
	}
	echo 'First = ' . $firstDigit . ', Last = ' . $lastDigit . ', Comb = ' . $combined . '<br>';
	echo '=====================================<br><br><br>';

	//STORE COMBINED IN THE VALUES ARRAY
	$values[] = $combined;
}

//GET THE SUM OF ALL VALUES
$total = array_sum($values);
//OUTPUT TOTAL
echo $total;
//40001 - too low
//50584 - too low
//53594 - too high
//53592 - correct! (have to check for two2two duplicated word numbers in each line!)