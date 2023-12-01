<?php

//ADVENT OF CODE 2022 - DAY 11

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT THE MONKEYS ARRAY
$monkeys = array();

//INIT ROUND
$round = 0;
//THE LIMIT
$roundLimit = 20;
//HOW MANY MONKEYS?
$monkeyCount = 8;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//ARE WE PROCESSING A NEW MONKEY?
		if(substr($line,0,6) === 'Monkey'){
			
			//PROCESS NEW MONKEY
			$monkeyId = substr($line,7,1);
			//CREATE MONKEY ARRAY
			$monkeys[$monkeyId] = array();
			//INITIALISE "inspects" TO 0
			$monkeys[$monkeyId]['inspects'] = 0;
		
		}else if(substr($line,2,14) === 'Starting items'){

			//PROCESS STARTING ITEMS
			$items = trim(substr($line, 18));
			//EXPLODE INTO ARRAY
			$items = explode(", ",$items);
			//SET ITEMS ARRAY
			$monkeys[$monkeyId]['items'] = $items;
		
		}else if(substr($line,2,9) === 'Operation'){

			//PROCESS OPERATION
			$opLine = substr($line, 20);
			$opLine = explode(" ",$opLine);
			//THE OPERAND (+, *, /, -)
			$operand = $opLine[1];
			//THE OPERATION FACTOR (1, 2, old, 7)
			$opFactor = trim($opLine[2]);
			$monkeys[$monkeyId]['opFactor'] = $opFactor;
			$monkeys[$monkeyId]['operand'] = $operand;
		
		}else if(substr($line,2,4) === 'Test'){

			//EXPLODE THE TEST LINE ON SPACES
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE DIVISOR)
			$divisor = trim(end($explodeTest));
			$monkeys[$monkeyId]['divisor'] = $divisor;
		
		}else if(substr($line,4,7) === 'If true'){

			//EXPLODE AND GET THE LAST
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE "TRUE" MONKEY)
			$trueThrow = trim(end($explodeTest));
			$monkeys[$monkeyId]['trueThrow'] = $trueThrow;

		}else if(substr($line,4,8) === 'If false'){

			//EXPLODE AND GET THE LAST
			$explodeTest = explode(" ",$line);
			//GET THE FINAL ELEMENT (THE "FALSE" MONKEY)
			$falseThrow = trim(end($explodeTest));
			$monkeys[$monkeyId]['falseThrow'] = $falseThrow;

		}
	}
}

//WHILE WE ARE STILL PROCESSING 
while ($round < $roundLimit){

	//ITERATE MONKEYS TO PROCESS THEM
	for($monkeyId = 0; $monkeyId < $monkeyCount; $monkeyId++){

		//MAKE REFERENCE TO CURRENT MONKEY
		$monkey = &$monkeys[$monkeyId];
		
		//ITERATE THROUGH THE MONKEY'S ITEMS
		foreach($monkey['items'] as $itemId => $item){

			//PROCESS THIS ITEM
			processItem($monkeyId, $item);
		}

		//CLEAR MONKEY'S ITEMS
		$monkeys[$monkeyId]['items'] = array();
	}

	//INCREMENT ROUND
	$round++;
}

//GET THE "INSPECTS" VALUES FOR EACH MONKEY
$inspects = array();
foreach($monkeys as $id => $monkey){
	$inspects[] = $monkey['inspects'];
}
//SORT DESCENDING
rsort($inspects);
//MULTIPLY THE TOP 2 ELEMENTS TOGETHER
echo '<h1>MULTIPLY TOP 2 = ' . ($inspects[0] * $inspects[1]) . '</h1>';

//PROCESS NEXT ITEM
function processItem($id, $item){

	global $monkeys;
	//MAKE REFERENCE TO THIS MONKEY
	$thisMonkey = &$monkeys[$id];

	$item = intval($item);

	//THIS MONKEY IS INSPECTING AN ITEM
	$thisMonkey['inspects'] = intval($thisMonkey['inspects']) + 1;

	//GET THE FACTOR (WHICH COULD BE THE "OLD" VALUE)
	$factor = ($thisMonkey['opFactor'] === 'old') ? $item : $thisMonkey['opFactor'];

	//SWITCH ON THE OPERAND
	switch($thisMonkey['operand']){

		case '+':
			$newItem = $item + $factor;
		break;

		case '*':
			$newItem = $item * $factor;
		break;

		case '-':
			$newItem = $item - $factor;
		break;

		case '/':
			$newItem = $item / $factor;
		break;
	}

	//MONKEY GETS BORED
	$newItem = floor($newItem / 3);

	//RUN THE TEST
	$result = ( ($newItem % $thisMonkey['divisor']) === 0);
	
	if($result){

		//GET THE "TRUE" MONKEY
		$trueMonkey = $thisMonkey['trueThrow'];
		//PUSH THE NEW ITEM ONTO THE TRUE MONKEY ITEMS
		array_push($monkeys[$trueMonkey]['items'],$newItem);

	}else{

		//GET THE "FALSE" MONKEY
		$falseMonkey = $thisMonkey['falseThrow'];
		//PUSH THE NEW ITEM ONTO THE FALSE MONKEY ITEMS
		array_push($monkeys[$falseMonkey]['items'],$newItem);
	}
}
