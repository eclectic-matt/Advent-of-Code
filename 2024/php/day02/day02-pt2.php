<?php

//TAKE INPUT (REMEMBER TO SAVE THE FILE, RATHER THAN COPY-PASTE LIKE AN EEJIT)
$input = file_get_contents("input.txt");

//SPLIT INPUT ON NEW LINES
$reports = explode("\n", $input);

$safeCount = 0;

foreach($reports as $report){
	$reportData = explode(' ', trim($report));
	//GET NUMBER OF FAILURES (REMOVING ONE ELEMENT EACH TIME)
	$failureCount = checkAllSplits($reportData);
	//IF THE NUMBER OF FAILURES (ARRAYS WHERE ONE ELEMENT REMOVED FAILS) IS LESS THAN THE COUNT - 1
	if($failureCount <= count($reportData) - 1){
		echo 'FAILURES: ' . $failureCount . ' - THIS REPORT IS SAFE<br>';
		$safeCount++;
	}else{
		echo 'FAILURES: ' . $failureCount .' - REPORT UNSAFE<br>';
	}
	echo '<br><hr><br>';
}

echo '<h1>SAFE COUNT: ' . $safeCount . '</h1>';
//558 too low
//704 too high
//516 too low
//561 - correct!


function checkReportSafety($reportData){
	//echo '<br><hr><br>';
	echo '<em>Checking report safety for "' . implode(',',$reportData) . '"</em><br>';
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

	echo 'all checks complete - safe!<br>';
	//REACHED THE BOTTOM - SAFE!
	return true;
}

function checkAllSplits($reportData){	
	//IF SAFE WITH NO REMOVALS, RETURN 0
	if(checkReportSafety($reportData)){
		return 0;
	}
	$failures = 0;
	$dataCopy = $reportData;
	for($i = 0; $i < count($reportData); $i++){
		//REMOVE ELEMENT AT INDEX $i AND CHECK 
		$dataCopy = $reportData;
		$removed = array_splice($dataCopy, $i, 1);
		echo '<br><em>checking without index ' . $i . ' = "' . $removed[0] . '"</em><br>'; 
		if(!checkReportSafety($dataCopy)){
			$failures++;
		}
	}
	return $failures;
}