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

				//FINISH STACK PROCESS, MOVING TIME
				$stackProcess = false;
				echo '<h1>INITIAL STACKS</h1>';
				echo '0 = bottom .... count = top<br>';
				outputStacks($stacks);
			}else{

				echo 'PROCESSING ROW ' . $line . '<br>';
				echo 'JOIN: ' . str_ireplace(' ','',$line) . '<br>';
				
				if(!is_numeric(preg_replace('/\s/','',$line))){

					$row = str_split($line, 4);
					for($i = 0; $i < count($row); $i++){
						
						//IGNORE BLANKS
						if (!ctype_space($row[$i])) {

							//CONVENIENCE
							$crateId = substr($row[$i],1,1);
							$stackId = $i + 1;

							if(isset($stacks[$stackId])){
								//PUT ONTO TOP OF THIS STACK
								echo 'Crate ' . $crateId . ' added to stack ' . $stackId . '<br>';
								array_unshift($stacks[$stackId], $crateId);
							}else{
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

			//PROCESS MOVEMENT
			$count = intval(substr($line, 4, strpos($line,'from') - 5));
			$from = intval(substr($line, strpos($line,'from') + 5, strpos($line,'to') - strpos($line,'from') - 6));
			$to = intval(substr($line, strpos($line,'to') + 3));
			echo 'LINE: ' . $line . '. MOVE ' . $count . ' FROM ' . $from . ' TO ' . $to . '<br>';
			$moved = '';
			for($i = 0; $i < $count; $i++){
				$moved = array_pop($stacks[$from]);
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
	//foreach($stacks as $index => $stack){
	for($i = 1; $i <= count($stacks); $i++){
		$stack = $stacks[$i];
		echo 'STACK ' . $i . ' => <br>';
		foreach($stack as $item){
			echo $item . '<br>';
		}
		echo '<br>';
	}
}

function outputAnswer($stacks){
	$answer = '';
	for($i = 1; $i <= count($stacks); $i++){
		$stack = $stacks[$i];
		$len = count($stack);
		$answer .= $stack[$len - 1];
	}
	return $answer;
}