<?php

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT TOTAL
$total = 0;
//INIT FOLDERS
$folders = array();
//CURRENT DIRECTORY
$currentDir = '';
$folders[$currentDir] = array();

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		if(substr($line,0,1) === "$"){

			//PROCESS COMMAND
			switch(substr($line,2,2)){
				case 'cd':

					$changeDir = trim(substr($line,4));
					if($changeDir === '..'){
						//UP ONE FOLDER
						$index = strrpos($currentDir,'/');
						$currentDir = substr($currentDir,0,$index);
						echo "UP 1 LEVEL to $currentDir<br>";
					}else{
						//DON'T CHANGE ROOT ON /
						if($changeDir !== '/'){
							//CHANGE DIR
							$currentDir .= '/' . $changeDir;
							echo "DOWN 1 LEVEL to $currentDir<br>";
						}
					}
				break;
				case 'ls':
					//LIST FILES - IGNORE?
				break;
			}

		}else if(substr($line,0,3) === "dir"){

			$dirName = trim(substr($line,3));
			//PROCESS DIR
			if(!isset($folders[$dirName])){
			
				//PREPARE FOLDER
				$folders[$dirName] = array();
			}
		}else{

			//PROCESS FILE
			$size = intval(explode(" ",$line)[0]);
			$name = explode(" ",$line)[1];
			$array = ["name"=>$name, "size"=>$size];

			//CHECK FOLDER SET
			if(!isset($folders[$currentDir])){

				//PREPARE ARRAY
				$folders[$currentDir] = array();
			}

			array_push($folders[$currentDir],$array);
		}
	}
}

$sum = 0;
foreach($folders as $index => $folder){

	$folderSize = 0;
	foreach($folder as $file){

		$folderSize += $file['size'];
	}
	
	if($folderSize <= 100000){
		$sum += $folderSize;
		echo '<b style="color: red;">';
	}else{
		echo '<b>';
	}

	echo array_keys($folders, $folder)[0];// . '<br>';
	echo ' - size ' . $folderSize;// . '<br>';
	echo ($folderSize < 100000) ? ' is below 100000</b><br>' : '</b><br>';
}


echo '<br>';
echo "<h3>FINAL SUM: $sum</h3>";
//var_dump($folders);
//INCORRECT GUESS: 1112994
//INCORRECT GUESS: 1482845