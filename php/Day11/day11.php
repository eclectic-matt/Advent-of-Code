<?php

//ADVENT OF CODE 2022 - DAY 11

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT THE MONKEYS ARRAY
$monkeys = array();

//INIT ROUND
$round = 0;
//
$roundLimit = 20;
$countItems = 0;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//ARE WE PROCESSING A NEW MONKEY?
		if(substr($line,0,6) === 'Monkey'){
			
			//PROCESS NEW MONKEY
			$monkeyId = substr($line,7,1);
			echo '<br><hr>PROCESSING MONKEY ' . $monkeyId . '<br>';
			$monkeys[$monkeyId] = array();
			$monkeys[$monkeyId]['inspects'] = 0;
		
		}else if(substr($line,2,14) === 'Starting items'){

			//PROCESS STARTING ITEMS
			$items = trim(substr($line, 18));
			$items = explode(", ",$items);
			echo 'MONKEY ' . $monkeyId . ' HAS ITEMS: "' . implode(",",$items) . '"<br>';
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
			echo 'OPERATION - OP=' . $operand . ', FACT=' . $opFactor . '<br>';
			$monkeys[$monkeyId]['opFactor'] = $opFactor;
			$monkeys[$monkeyId]['operand'] = $operand;
		
		}else if(substr($line,2,4) === 'Test'){

			//EXPLODE THE TEST LINE ON SPACES
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$divisor = trim(end($explodeTest));
			echo 'TEST IS DIVISIBLE BY ' . $divisor . '<br>';
			$monkeys[$monkeyId]['divisor'] = $divisor;
		
		}else if(substr($line,4,7) === 'If true'){

			//EXPLODE AND GET THE LAST
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$trueThrow = trim(end($explodeTest));
			echo 'IF TRUE, THROW TO ' . $trueThrow . '<br>';
			$monkeys[$monkeyId]['trueThrow'] = $trueThrow;

		}else if(substr($line,4,8) === 'If false'){

			//EXPLODE AND GET THE LAST
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$falseThrow = trim(end($explodeTest));
			echo 'IF FALSE, THROW TO ' . $falseThrow . '<br>';
			$monkeys[$monkeyId]['falseThrow'] = $falseThrow;

		}
	}
}

//WHILE WE ARE STILL PROCESSING 
while ($round < $roundLimit){

	//OUTPUT ROUND HEADER
	echo '<h2>ROUND ' . ($round + 1) . '</h2>';

	//ITERATE MONKEYS TO PROCESS THEM
	foreach($monkeys as $id => $monkey){

		echo '<h3>PROCESS MONKEY ' . $id . ', ITEMS = ' . implode(",",$monkey['items']) . '</h3>';
		//ITERATE THROUGH THE MONKEY'S ITEMS
		foreach($monkey['items'] as $itemId => $item){

			echo '<div style="border: 3px solid black; background-color: yellow;">PROCESSING ITEM ' . $itemId . ' = ' . $item . '<br>';
			//PROCESS THIS ITEM
			processItem($id, $item);

			//REMOVE THIS ITEM
			//unset($monkeys[$id]['items'][$itemId]);

			//array_splice($monkeys[$id]['items'],$itemId,1);

			/*$monkeys[$id]['items'] = array_filter($monkeys[$id]['items'], function($v){
				//global $itemId;
				//return $k !== $itemId;
				global $item;
				return $v !== $item;
			});*/

			/*$monkeys[$id]['items'] = array_filter($monkeys[$id]['items'], function($k){
				global $itemId;
				return $k != $itemId;
			}, ARRAY_FILTER_USE_KEY);*/

			//echo 'MONKEY ' . $id . ' NOW HAS ITEMS=' . implode(",",$monkey['items']) . '<br>';
			echo '</div>';
			//echo 'MONKEY ' . $id . ' NOW HAS ITEMS=' . implode(",",$monkey['items']) . '<br>';
		}

		//CLEAR MONKEY'S ITEMS
		$monkeys[$id]['items'] = array();
		echo 'MONKEY ' . $id . ' NOW HAS ITEMS=' . implode(",",$monkeys[$id]['items']) . '<br>';
	}

	//INCREMENT ROUND
	$round++;
}
echo '<h1>TOTAL INITIAL ITEMS = ' . $countItems . '</h1>';

//OUTPUT ANSWER
echo '<pre>';
var_dump($monkeys);
//SPLIT INTO LINES OF LENGTH 40
echo '</pre>';

//12876 too low
//20022 too low
//16442400 too high

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
	echo 'MONKEY ' . $id . ' INSPECTED ' . $monkey['inspects'] . ' ITEMS AND ENDED WITH ' . count($monkey['items']) . '<br>';
	$countItems += count($monkey['items']);
	$inspects[] = $monkey['inspects'];
}
rsort($inspects);
echo '<h1>TOTAL END ITEMS = ' . $countItems . '</h1>';
echo '<h1>MULTIPLY TOP 2 = ' . ($inspects[0] * $inspects[1]) . '</h1>';

//PROCESS NEXT ITEM
function processItem($id, $item){

	global $monkeys;
	//MAKE REFERENCE TO THIS MONKEY
	$thisMonkey = &$monkeys[$id];

	$item = intval($item);

	//THIS MONKEY IS INSPECTING AN ITEM
	$thisMonkey['inspects'] = intval($thisMonkey['inspects']) + 1;
	echo 'Monkey ' . $id . ' inspects an item with a worry level of ' . $item . '<br>';

	//GET THE FACTOR (WHICH COULD BE THE "OLD" VALUE)
	$factor = ($thisMonkey['opFactor'] === 'old') ? $item : $thisMonkey['opFactor'];

	echo 'Worry level is ';
	//SWITCH ON THE OPERAND
	switch($thisMonkey['operand']){

		case '+':
			$newItem = $item + $factor;
			echo 'increased by ' . $factor . ' to ' . $newItem . '<br>';
		break;

		case '*':
			$newItem = $item * $factor;
			echo 'multiplied by ' . $factor . ' to ' . $newItem . '<br>';
		break;

		case '-':
			$newItem = $item - $factor;
			echo 'reduced by ' . $factor . ' to ' . $newItem . '<br>';
		break;

		case '/':
			$newItem = $item / $factor;
			echo 'divided by ' . $factor . ' to ' . $newItem . '<br>';
		break;
	}

	//MONKEY GETS BORED
	$newItem = floor($newItem / 3);
	echo 'Monkey gets bored with item. Worry level is divided by 3 to ' . $newItem . '<br>';

	//RUN THE TEST
	$result = ( ($newItem % $thisMonkey['divisor']) === 0);
	
	if($result){

		//GET THE "TRUE" MONKEY
		$trueMonkey = $thisMonkey['trueThrow'];
		//PUSH THE NEW ITEM ONTO THE TRUE MONKEY ITEMS
		$monkeys[$trueMonkey]['items'][] = intval($newItem);
		echo 'Current worry level IS divisible by ' . $thisMonkey['divisor'] . '<br>';
		echo 'Item with worry level ' . $newItem . ' is thrown to monkey ' . $trueMonkey . '<br>';
	}else{

		//GET THE "FALSE" MONKEY
		$falseMonkey = $thisMonkey['falseThrow'];
		//PUSH THE NEW ITEM ONTO THE FALSE MONKEY ITEMS
		$monkeys[$falseMonkey]['items'][] = intval($newItem);
		echo 'Current worry level is not divisible by ' . $thisMonkey['divisor'] . '<br>';
		echo 'Item with worry level ' . $newItem . ' is thrown to monkey ' . $falseMonkey . '<br>';
	}

	//SLICE ITEMS FROM 1 - END (REMOVE 0)
	//$thisMonkey['items'] = array_slice($thisMonkey['items'],1,null,true);
	//echo '<em>Monkey should now have: ' . implode(',',array_slice($thisMonkey['items'],1,null,true)) . '<br>';
	//$monkeys[$id]['items'] = array_slice($thisMonkey['items'],1,null,true);
}
