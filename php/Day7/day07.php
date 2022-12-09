<?php

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT TOTAL
$total = 0;
//INIT FOLDERS
$folders = array();
//CURRENT DIRECTORY
$currentDir = '';
$folders[$currentDir] = 0;//array();

echo '<pre>';

if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//IF THE LINE STARTS WITH "$" (COMMAND)
		if(substr($line,0,1) === "$"){

			//PROCESS COMMAND
			switch(substr($line,2,2)){

				//THE COMMAND IS "cd"
				case 'cd':

					//GET THE DIRECTORY TO CHANGE TO
					$changeDir = trim(substr($line,4));

					//IF THIS IS ".."
					if($changeDir === '..'){
						
						//GO UP ONE FOLDER
						$index = strrpos($currentDir,'/');
						$currentDir = substr($currentDir,0,$index);
						echo "UP&nbsp;&nbsp;&nbsp;$currentDir<br>";
					}else{
						//DON'T CHANGE ROOT ON /
						if($changeDir !== '/'){

							
							//CHANGE DIR
							$currentDir .= '/' . $changeDir;

							//VARIABLE INTERPOLATION ON AN ARRAY STRUCTURE?!?! CURSED, FOR SURE
							$cursedString = '$folders["' . str_ireplace("/",'"]["',$currentDir) . '"]<br>';
							
							//IF THIS CURSED FOLDER IS NOT SET
							if(!isset($$cursedString)){
								//SET IT TO 0
								$$cursedString = 0;
							}
							echo "DOWN&nbsp;$currentDir<br>";
						}
					}
				break;
				//THE COMMAND IS "ls"
				case 'ls':
					//LIST FILES - IGNORE?
				break;
			}

		//ELSE IF WE ARE STARTING WITH "dir"
		}else if(substr($line,0,3) === "dir"){

			//GET THE DIRECTORY NAME
			$dirName = trim(substr($line,3));
			//PROCESS DIR
			if(!isset($folders[$dirName])){
			
				//PREPARE FOLDER (WILL ADD FILES SOON)
				$folders[$dirName] = array();
			}
		}else{

			//PROCESS FILE
			$size = intval(explode(" ",$line)[0]);
			$name = explode(" ",$line)[1];
			$array = ["name"=>$name, "size"=>$size];
			$cursedString = '$folders["' . str_ireplace("/",'"]["',$currentDir) . '"]<br>';

			//CHECK FOLDER SET
			//if(!isset($folders[$currentDir])){
			if(!isset($$cursedString)){

				//PREPARE ARRAY
				//$folders[$currentDir] = array();
				//$folders[$currentDir] = 0;
				$$cursedString = 0;
			}


			//ALSO STORE SIZE ON HIGHER-LEVEL FOLDERS
			/*$slashCount = strlen($currentDir) - strlen(str_ireplace($currentDir,"/",""));
			$slashOffset = 0;
			for($i = 0; $i < $slashCount; $i++){

				$slashIndex = strrpos($currentDir,"/",$slashOffset);
				$slashOffset = $slashIndex;	//STORE TO OFFSET NEXT RUN
				$folderUp = substr($currentDir,0,$slashIndex);
				$folders[$folderUp] = ($folders[$currentDir] + $size);
			}*/

			if($$cursedString === 0){
				$$cursedString = $size;
			}else{
				$$cursedString = $$cursedString + $size;
			}
			/*if($folders[$currentDir] === 0){
				$folders[$currentDir] = $size;
				
			}else{
				$folders[$currentDir] = ($folders[$currentDir] + $size);
			}*/
		}
	}
}

echo '</pre>';
//var_dump($folders);
$limit = 100000;

$sum = 0;


foreach($folders as $folder){
	//echo $folder . '<br>';
	$size = recursiveSum($folder);

	if($size < $limit){
		$sum += $size;
	}
}
echo '<br>';
echo "<h3>FINAL SUM: $sum</h3>";

function recursiveSum($folder){
	$sum = 0;
	if(is_array($folder)){
		$sum += recursiveSum($folder);
	}else{
		$sum += $folder;
	}
	return $sum;
}
die();


foreach($folders as $index => $folder){

	/*$folderSize = 0;
	foreach($folder as $file){

		//$folderSize += $file['size'];
		$folderSize += $file;
	}*/
	
	if($folder <= 100000){
		$sum += $folder;
		echo '<b style="color: red;">';
	}else{
		echo '<b>';
	}

	echo array_keys($folders, $folder)[0];// . '<br>';
	echo ' - size ' . $folder[0];// . '<br>';
	echo ($folder < 100000) ? ' is below 100000</b><br>' : '</b><br>';
}


echo '<br>';
echo "<h3>FINAL SUM: $sum</h3>";

//INCORRECT GUESS: 1112994
//INCORRECT GUESS: 1482845