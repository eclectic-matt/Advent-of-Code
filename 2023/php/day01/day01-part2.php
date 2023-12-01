<?php 

$input = file_get_contents("input.txt");

//SPLIT ON NEW LINES
$lines = explode("\n", $input);

//PREPARE AN OUTPUT ARRAY
$values = array();
$words = array(1=>'one', 2=>'two', 3=>'three', 4=>'four', 5=>'five', 6=>'six', 7=>'seven', 8=>'eight', 9=>'nine' );

foreach($lines as $line){

	$lineWords = array();

	echo '<h1>' . $line . '</h1>';

	foreach($words as $wordIndex => $wordString){

		//CHECK AT EACH POSITION WITHIN THE LINE
		for($i = 0; $i < strlen($line); $i++){
			$index = strpos(substr($line,$i), $wordString);
			if($index !== false){
				//echo $wordString . ' found at position ' . ($index + $i) . '<br>';
				$lineWords[($index + $i)] = $wordIndex;
			}
		}
		
	}
	//echo 'LineWords = ' . implode(',', $lineWords) . '<br>';

	$split = str_split($line,1);
	$index = 0;
	foreach($split as $char){
		if(is_numeric($char)){
			$lineWords[$index] = $char;
			//echo $char . ' found at position ' . $index . '<br>';
		}
		$index++;
	}

	ksort($lineWords,SORT_NUMERIC);
	$firstDigit = array_shift($lineWords);
	$lastDigit = array_pop($lineWords);
	if(is_null($lastDigit)){
		$lastDigit = $firstDigit;
	}
	$combined = $firstDigit . $lastDigit;

	echo '=====================================<br>';
	//echo 'LineWords = ' . implode(',', $lineWords) . '<br>';
	foreach($lineWords as $index => $digit){
		echo 'LineWords ' . $index . ' = ' . $digit . '<br>';
	}
	echo 'First = ' . $firstDigit . ', Last = ' . $lastDigit . ', Comb = ' . $combined . '<br>';
	echo '=====================================<br><br><br>';

	$values[] = $combined;
}

$total = array_sum($values);
echo $total;
//40001 - too low
//50584 - too low
//53594 - too high
//53592 - correct! (have to check for two2two duplicated word numbers in each line!)