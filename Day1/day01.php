<?php

$input = file_get_contents("input01.txt");
//var_dump($input);

$inventories = explode("/n/r/n/r", $input);

$elves = array();
//var_dump($inventories);

foreach($inventories as $index => $items){
	$total = 0;
	$items = explode("/n/r", $items);
	foreach($items as $item){
		$total += intval($item);
	}
	$elves[$index] = $total;
}

$maxCalories = max($elves);
$elfId = array_keys($elves, $maxCalories)[0];
echo "The elf with ID " . $elfId . " has " . $maxCalories . " calories";