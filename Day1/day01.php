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

//GET THE LARGEST VALUE FROM THE ELVES ARRAY
$maxCalories = max($elves);
//GET THE ASSOCIATED KEY
$elfId = array_keys($elves, $maxCalories)[0];

//OUTPUT THE ELF WITH THE MOST CALORIES
echo "The elf with ID " . $elfId . " has " . $maxCalories . " calories";