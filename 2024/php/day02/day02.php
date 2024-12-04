<?php

//TAKE INPUT (REMEMBER TO SAVE THE FILE, RATHER THAN COPY-PASTE LIKE AN EEJIT)
$input = file_get_contents("input.txt");

//SPLIT INPUT ON NEW LINES
$reports = explode("\n", $input);

$safeCount = 0;

foreach($reports as $report){
	$reportData = explode(' ', trim($report));
	if(checkReportSafety($reportData)){
		$safeCount++;
	}
}

echo 'SAFE COUNT: ' . $safeCount;

function checkReportSafety($reportData){
	echo '<br><hr><br>';
	echo 'Checking report safety for "' . implode(',',$reportData) . '"<br>';
	$previous = false;
	$increasing = null;
	foreach($reportData as $level){
		echo ' --> Checking "' . $level . '" (previous: ' . $previous . ')<br>';
		//NO PREVIOUS VALUE TO CHECK
		if(!$previous){
			//NOTHING TO CHECK (WILL STORE AT BOTTOM OF FUNCTION)
		}else{
			//PERFORM CHECKS
			if(abs($level - $previous) > 3){
				//NOT SAFE, DIFFERENCE > 3
				echo 'UNSAFE - DIFF > 3<br>';
				return false;
			}else if(abs($level - $previous) < 1){
				//NOT SAFE, DIFFERENCE OF < 1
				echo 'UNSAFE - DIFF < 1<br>';
				return false;
			}

			if($level > $previous){
				if($increasing === false){
					//NOT SAFE, PREVIOUSLY DECREASING, NOW INCREASING
					echo 'UNSAFE - WAS DECREASING, NOW INCREASING<br>';
					return false;
				}
			}else if($level < $previous){
				if($increasing === true){
					//NOT SAFE, PREVIOUSLY INCREASING, NOW DECREASING
					echo 'UNSAFE - WAS INCREASING, NOW DECREASING<br>';
					return false;
				}
			}
			//SET INCREASING NOW
			if(is_null($increasing)){
				if($level > $previous){
					$increasing = true;
				}else{
					$increasing = false;
				}
			}
		}
		//STORE THE CURRENT LEVEL
		$previous = $level;
	}
	//REACHED THE BOTTOM - SAFE!
	return true;
}