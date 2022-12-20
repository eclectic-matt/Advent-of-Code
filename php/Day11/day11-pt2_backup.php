<?php

//ADVENT OF CODE 2022 - DAY 11

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");
//$handle = fopen("test.txt", "r");

//INIT THE MONKEYS ARRAY
$monkeys = array();

//INIT ROUND
$round = 0;
//
$roundLimit = 10000;
$countItems = 0;


if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//ARE WE PROCESSING A NEW MONKEY?
		if(substr($line,0,6) === 'Monkey'){
			
			//PROCESS NEW MONKEY
			$monkeyId = substr($line,7,1);
			//echo '<br><hr>PROCESSING MONKEY ' . $monkeyId . '<br>';
			$monkeys[$monkeyId] = array();
			$monkeys[$monkeyId]['inspects'] = 0;
		
		}else if(substr($line,2,14) === 'Starting items'){

			//PROCESS STARTING ITEMS
			$items = trim(substr($line, 18));
			$items = explode(", ",$items);
			//echo 'MONKEY ' . $monkeyId . ' HAS ITEMS: "' . implode(",",$items) . '"<br>';
			$monkeys[$monkeyId]['items'] = $items;
			$countItems += count($items);
		
		}else if(substr($line,2,9) === 'Operation'){

			//PROCESS OPERATION
			$opLine = substr($line, 20);
			$opLine = explode(" ",$opLine);
			//THE OPERAND (+, *, /, -)
			$operand = $opLine[1];
			//THE OPERATION FACTOR (1, 2, old, 7)
			$opFactor = trim($opLine[2]);
			//echo 'OPERATION - OP=' . $operand . ', FACT=' . $opFactor . '<br>';
			$monkeys[$monkeyId]['opFactor'] = $opFactor;
			$monkeys[$monkeyId]['operand'] = $operand;
		
		}else if(substr($line,2,4) === 'Test'){

			//EXPLODE THE TEST LINE ON SPACES
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$divisor = trim(end($explodeTest));
			//echo 'TEST IS DIVISIBLE BY ' . $divisor . '<br>';
			$monkeys[$monkeyId]['divisor'] = $divisor;
		
		}else if(substr($line,4,7) === 'If true'){

			//EXPLODE AND GET THE LAST
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$trueThrow = trim(end($explodeTest));
			//echo 'IF TRUE, THROW TO ' . $trueThrow . '<br>';
			$monkeys[$monkeyId]['trueThrow'] = $trueThrow;

		}else if(substr($line,4,8) === 'If false'){

			//EXPLODE AND GET THE LAST
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$falseThrow = trim(end($explodeTest));
			//echo 'IF FALSE, THROW TO ' . $falseThrow . '<br>';
			$monkeys[$monkeyId]['falseThrow'] = $falseThrow;

		}
	}
}


$monkeyCount = $monkeyId + 1;
echo 'MONKEY COUNT : ' . $monkeyCount . '<br>';

echo '<pre>';
var_dump($monkeys);
//SPLIT INTO LINES OF LENGTH 40
echo '</pre>';

//OUTPUT TOTAL ITEMS
echo '<h1>TOTAL INITIAL ITEMS = ' . $countItems . '</h1>';

//WHILE WE ARE STILL PROCESSING 
while ($round < $roundLimit){

	//OUTPUT ROUND HEADER
	//echo '<h2>ROUND ' . ($round + 1) . '</h2>';

	//ITERATE MONKEYS TO PROCESS THEM
	for($monkeyId = 0; $monkeyId < $monkeyCount; $monkeyId++){

		//MAKE REFERENCE TO CURRENT MONKEY
		//$monkey = &$monkeys[$monkeyId];

		//echo '<h3>PROCESS MONKEY ' . $monkeyId . ', ITEMS = ' . implode(", ",$monkey['items']) . '</h3>';
		//echo '<h3>PROCESS MONKEY ' . $monkeyId . ', ITEMS = ' . implode(", ",$monkeys[$monkeyId]['items']) . '</h3>';
		
		$itemCount = count($monkeys[$monkeyId]['items']);
		//echo '<em>This monkey has ' . $itemCount . ' items</em><br>';

		//ITERATE THROUGH THE MONKEY'S ITEMS
		//foreach($monkey['items'] as $itemId => $item){
		//foreach($monkeys[$monkeyId]['items'] as $itemId => $item){
		for($itemId = 0; $itemId < $itemCount; $itemId++){

			$item = $monkeys[$monkeyId]['items'][$itemId];
			//echo '<div style="border: 3px solid black; background-color: yellow;">PROCESSING ITEM ' . $itemId . ' = ' . $item . '<br>';
				//PROCESS THIS ITEM
				processItem($monkeyId, $item);
			//echo '</div>';
		}

		//CLEAR MONKEY'S ITEMS
		$monkeys[$monkeyId]['items'] = array();
		//echo 'MONKEY ' . $monkeyId . ' NOW HAS ITEMS=' . implode(", ",$monkeys[$monkeyId]['items']) . '<br>';
	}

	//INCREMENT ROUND
	$round++;
}


//OUTPUT ANSWER
echo '<pre>';
var_dump($monkeys);
//SPLIT INTO LINES OF LENGTH 40
echo '</pre>';

///PART 2
//18273065976 too high
//18303264239 too high

	/*
	Monkey inspects an item with a worry level of 79.
    Worry level is multiplied by 19 to 1501.
    Monkey gets bored with item. Worry level is divided by 3 to 500.
    Current worry level is not divisible by 23.
    Item with worry level 500 is thrown to monkey 3.
	*/

$inspects = array();
$countItems = 0;
foreach($monkeys as $id => $monkey){
	//echo 'MONKEY ' . $id . ' INSPECTED ' . $monkey['inspects'] . ' ITEMS AND ENDED WITH ' . count($monkey['items']) . '<br>';
	$countItems += count($monkey['items']);
	$inspects[] = $monkey['inspects'];
}
rsort($inspects);
echo '<h1>TOTAL END ITEMS = ' . $countItems . '</h1>';
//echo '<h1>MULTIPLY TOP 2 = ' . ($inspects[0] * $inspects[1]) . '</h1>';
echo '<h1>MULTIPLY TOP 2 = ' . gmp_mul($inspects[0], $inspects[1]) . '</h1>';







//PROCESS NEXT ITEM
function processItem($id, $item){

	//echo '<em>Process Item ' . $item . ' for monkey ' . $id . '</em><br>';
	global $monkeys;
	//MAKE REFERENCE TO THIS MONKEY
	//$thisMonkey = &$monkeys[$id];
	

	//$item = intval($item);

	//THIS MONKEY IS INSPECTING AN ITEM
	//$thisMonkey['inspects'] = intval($thisMonkey['inspects']) + 1;
	$monkeys[$id]['inspects'] = intval($monkeys[$id]['inspects']) + 1;
	//echo 'Monkey ' . $id . ' inspects an item with a worry level of ' . $item . '<br>';

	//GET THE FACTOR (WHICH COULD BE THE "OLD" VALUE)
	//$factor = ($thisMonkey['opFactor'] === 'old') ? $item : $thisMonkey['opFactor'];
	$factor = ($monkeys[$id]['opFactor'] === 'old') ? $item : $monkeys[$id]['opFactor'];

	//echo 'Worry level is ';
	//SWITCH ON THE OPERAND
	//switch($thisMonkey['operand']){
	switch($monkeys[$id]['operand']){

		case '+':
			//$newItem = $item + $factor;
			$newItem = gmp_add($item, $factor);
			//echo 'Worry level increased by ' . $factor . ' to ' . $newItem . '<br>';
			//echo 'increased by ' . $factor . ' to ' . $newItem . '<br>';
		break;

		case '*':
			//$newItem = $item * $factor;
			$newItem = gmp_mul($item, $factor);
			//echo 'Worry level multiplied by ' . $factor . ' to ' . $newItem . '<br>';
		break;

		/*
		NONE OF THE MONKEYS USE THESE, REMOVING TO SAVE CONFUSION!

		case '-':
			$newItem = $item - $factor;
			//echo 'reduced by ' . $factor . ' to ' . $newItem . '<br>';
		break;

		case '/':
			$newItem = $item / $factor;
			$newItem = gmp_div_q($item, $factor, GMP_ROUND_ZERO);
			//echo 'divided by ' . $factor . ' to ' . $newItem . '<br>';
		break;
		*/

		default:
			//echo '<b>NO OPERAND FOUND FOR THIS MONKEY!</b><br>';
		break;
	}

	//MONKEY GETS BORED
	//$newItem = floor($newItem / 1);
	//echo 'Monkey gets bored with item. Worry level is NOT DIVIDED AND SO IS STILL ' . $newItem . '<br>';

	//RUN THE TEST
	//$result = ( ($newItem % $thisMonkey['divisor']) === 0);

	//RUN THE TEST USING THE DIVISOR METHOD
	//$result = (gmp_div_r(intval($newItem), intval($thisMonkey['divisor']), GMP_ROUND_ZERO) == 0);
	//$result = (gmp_div_r($newItem, $thisMonkey['divisor'], GMP_ROUND_ZERO) == 0);
	$result = (gmp_div_r($newItem, $monkeys[$id]['divisor'], GMP_ROUND_ZERO) == 0);

	
	if($result){

		//GET THE "TRUE" MONKEY
		//$trueMonkey = $thisMonkey['trueThrow'];
		$trueMonkey = $monkeys[$id]['trueThrow'];
		//PUSH THE NEW ITEM ONTO THE TRUE MONKEY ITEMS
		//array_push($monkeys[$trueMonkey]['items'],gmp_init($newItem));
		array_push($monkeys[$trueMonkey]['items'],$newItem);
		
		
		//$monkeys[$trueMonkey]['items'][] = intval($newItem);
		//echo 'Current worry level IS divisible by ' . $thisMonkey['divisor'] . '<br>';
		//echo 'Item with worry level ' . $newItem . ' is thrown to monkey ' . $trueMonkey . '<br>';
	}else{

		//GET THE "FALSE" MONKEY
		//$falseMonkey = $thisMonkey['falseThrow'];
		$falseMonkey = $monkeys[$id]['falseThrow'];
		//PUSH THE NEW ITEM ONTO THE FALSE MONKEY ITEMS
		//$monkeys[$falseMonkey]['items'][] = intval($newItem);
		//array_push($monkeys[$falseMonkey]['items'],gmp_init($newItem));
		array_push($monkeys[$falseMonkey]['items'],$newItem);


		//echo 'Current worry level is not divisible by ' . $thisMonkey['divisor'] . '<br>';
		//echo 'Item with worry level ' . $newItem . ' is thrown to monkey ' . $falseMonkey . '<br>';
	}

	//SLICE ITEMS FROM 1 - END (REMOVE 0)
	//$thisMonkey['items'] = array_slice($thisMonkey['items'],1,null,true);
	//echo '<em>Monkey should now have: ' . implode(',',array_slice($thisMonkey['items'],1,null,true)) . '<br>';
	//$monkeys[$id]['items'] = array_slice($thisMonkey['items'],1,null,true);
}

