<?php

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
sort($leftList, SORT_NUMERIC);
sort($rightList, SORT_NUMERIC);
//INIT THE TOTAL DIFF
$totalDiff = 0;

//ITERATE THROUGH THE SORTED LISTS BY INDEX
for($i = 0; $i < count($leftList); $i++){
	$currentDiff = abs(intval($leftList[$i]) - intval($rightList[$i]));
	$totalDiff += $currentDiff;
}

echo $totalDiff;
//54674307 = too high (exploding was incorrect)
//2580760 = correct!