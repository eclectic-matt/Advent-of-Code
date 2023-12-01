<?php

//TAKE INPUT (REMEMBER TO SAVE THE FILE, RATHER THAN COPY-PASTE LIKE AN EEJIT)
$input = file_get_contents("input.txt");

//SPLIT ON TWO NEW LINES
$inventories = explode("\n\n", $input);

//PREPARE AN OUTPUT ARRAY
$elves = array();

//ITERATE THROUGH THE INVENTORIES
foreach($inventories as $index => $items){

	//INITIALIZE THE TOTAL
	$total = 0;
	//EXPLODE THE CURRENT ITEMS ON A NEW LINE
	$items = explode("\n", $items);

	//ITERATE THROUGH CURRENT ITEMS
	foreach($items as $item){

		//ADD ONTO THE TOTAL (TAKE INTEGER VALUE)
		$total += intval($item);
	}

	//STORE THIS TOTAL IN THE ELVES ARRAY
	$elves[$index] = $total;
	//echo "Elf $index has $total calories<br><br>";
}

//SORT THE ELVES ARRAY BY LARGEST TO SMALLEST
rsort($elves,SORT_NUMERIC);

//DEFINE THE TOP "3" ELVES
$topElfCount = 3;
//INITIALIZE THE TOTAL CALORIES COUNT
$topElfCalories = 0;

//ITERATE THE TOP ELVES
for($i = 0; $i < $topElfCount; $i++){
	
	//ADD THE ELF CALORIES TO THE TOTAL CALORIES COUNT
	$topElfCalories += $elves[$i];
}

//OUTPUT THE CALORIES FOR THE TOP ELVES
echo "The top $topElfCount elves have a total of $topElfCalories calories";