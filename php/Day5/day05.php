<?php

//ADVENT OF CODE 2022
//DAY 5

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT TOTAL
$total = 0;

//INIT STACK ARRAY
$stacks = array();
//PROCESS FLAG
$stackProcess = true;

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//PART 1 - READ CRATE LAYOUT
		if($stackProcess){

			//HAVE WE REACHED A BLANK LINE?
			if(ctype_space($line)) {

				//FINISH STACK PROCESS, MOVING TIME (DO NOTHING WITH THIS LINE)
				$stackProcess = false;
				//OUTPUT THE INITIAL STACKS
				echo '<h1>INITIAL STACKS</h1>';
				echo '0 = bottom .... count = top<br>';
				outputStacks($stacks);
			}else{

				//PROCESS AN INITIAL STACK ROW
				echo 'PROCESSING ROW ' . $line . '<br>';
				echo 'JOIN: ' . str_ireplace(' ','',$line) . '<br>';
				
				//CHECK IF THIS LINE IS ALL NUMERIC (STACK NUMBERS)
				if(!is_numeric(preg_replace('/\s/','',$line))){

					//SPLIT THE LINE INTO COLUMNS OF SIZE 4 "[A] "
					$row = str_split($line, 4);
					//ITERATE THROUGH THE COLUMNS
					for($i = 0; $i < count($row); $i++){
						
						//IGNORE BLANKS
						if (!ctype_space($row[$i])) {

							//CONVENIENCE - GET THE CRATE LETTER
							$crateId = substr($row[$i],1,1);
							//THE STACK NUMBER IS 1-INDEXED
							$stackId = $i + 1;

							//IF THERE IS ALREADY A STACK
							if(isset($stacks[$stackId])){
								//PUT ONTO TOP OF THIS STACK
								echo 'Crate ' . $crateId . ' added to stack ' . $stackId . '<br>';
								array_unshift($stacks[$stackId], $crateId);
							}else{
								//CREATE A STACK AND SET CRATE
								echo 'Crate ' . $crateId . ' is the first in stack ' . $stackId . '<br>';
								$stacks[$stackId] = array();
								$stacks[$stackId][] = $crateId;
							}
						}
					}
				}

				echo '<br><br>';
			}
		}else{

			//PART 2 - PROCESS MOVEMENT
			
			//SPLIT LINE INTO COUNT, FROM, TO
			$count = intval(substr($line, 4, strpos($line,'from') - 5));
			$from = intval(substr($line, strpos($line,'from') + 5, strpos($line,'to') - strpos($line,'from') - 6));
			$to = intval(substr($line, strpos($line,'to') + 3));
			echo 'LINE: ' . $line . '. MOVE ' . $count . ' FROM ' . $from . ' TO ' . $to . '<br>';
			//ONE AT A TIME UP TO THE COUNT...
			for($i = 0; $i < $count; $i++){
				//GET THE MOVED ELEMENT (POP FROM END)
				$moved = array_pop($stacks[$from]);
				//PUSH THE MOVED ELEMENT ONTO ANOTHER STACK
				array_push($stacks[$to],$moved);
			}
		}
	}

	fclose($handle);
}

//asort($stacks);
echo '<h1>FINAL STACKS</h1>';
echo '0 = bottom .... count = top<br>';

outputStacks($stacks);


echo '<h3>The solution is: ';
echo outputAnswer($stacks);
echo '</h3>';


function outputStacks($stacks){

	//ITERATE THE STACKS
	for($i = 1; $i <= count($stacks); $i++){

		//GET THE CURRENT STACK
		$stack = $stacks[$i];
		echo 'STACK ' . $i . ' => <br>';

		//ITERATE STACK ITEMS (BOTTOM -> TOP)
		foreach($stack as $item){

			echo $item . '<br>';
		}
		echo '<br>';
	}
}


function outputAnswer($stacks){

	//INIT ANSWER STRING
	$answer = '';

	//ITERATE STACKS
	for($i = 1; $i <= count($stacks); $i++){
		
		//GET CURRENT STACK
		$stack = $stacks[$i];
		//GET THE LENGTH
		$len = count($stack);
		//ADD FINAL ITEM TO ANSWER
		$answer .= $stack[$len - 1];
	}
	return $answer;
}