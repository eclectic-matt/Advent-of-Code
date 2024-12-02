<?php

//DAY 1 - PART 2

//TAKE INPUT (REMEMBER TO SAVE THE FILE, RATHER THAN COPY-PASTE LIKE AN EEJIT)
$input = file_get_contents("input.txt");

//INITIALISE THE LEFT/RIGHT LISTS TO SORT
$leftList = array();
$rightList = array();

//SPLIT INPUT ON NEW LINES
$lists = explode("\n", $input);

foreach($lists as $listItem){
	$locations = explode('   ', $listItem);
	$leftList[] = $locations[0];
	$rightList[] = $locations[1];
}
//SORT EACH LIST NUMERICALLY
//sort($leftList, SORT_NUMERIC);
//sort($rightList, SORT_NUMERIC);

$rightCounts = array_count_values($rightList);
//sort($rightCounts, SORT_NUMERIC);
ksort($rightCounts, SORT_NUMERIC);
var_dump($rightCounts);

//INIT THE SIMILARITY SCORE
$similarity = 0;

//ITERATE THROUGH THE SORTED LISTS BY INDEX
for($i = 0; $i < count($leftList); $i++){
	
	$currentVal = intval($leftList[$i]);
	echo 'CHECKING RIGHT LIST FOR "' . $currentVal . '"';
	if(array_key_exists($currentVal, $rightCounts)){
		$rightCount = $rightCounts[$currentVal];
		$similarity += ($currentVal * $rightCount);
		echo ' WHICH WAS FOUND ' . $rightCount . ' TIMES, SO SIMILARITY += ' . ($currentVal * $rightCount);
	}else{
		$similarity += 0;
		echo ' which was not found in the right counts';
	}

	echo '<br>';
}

echo $similarity;
