<# POWERSHELL - ADVENT OF CODE 2022 - DAY 3, PART 2 #>

#UTILITY TO GET THE PRIORITY VALUE FROM A CHAR
function Get-Priority(){

	param(
		[Parameter(Mandatory=$true)] [char]$char
	)
	$ascii = [int]$char;
	if($ascii -gt 96){
		return ($ascii - 96);
	}else{
		return ($ascii - 38);
	}
}

#GET INPUT
$file = "input.txt";

#READ FILE INTO VARIABLE
$content = Get-Content -Path $file;

#INIT TOTAL
$total = 0;
#GROUP SIZE
$groupSize = 3;
#GROUPS OF THREE
$groups = @();

#ITERATE THROUGH LINES IN THE INPUT FILE
foreach($line in $content){
	
	#ADD THIS LINE TO THE GROUPS ARRAY
	$groups += $line;

	#IF WE HAVE ENOUGH GROUPS TO PROCESS A BATCH
	if($groups.count -eq $groupSize){

		#ITERATE THROUGH CHARACTERS IN THE FIRST LINE
		for($i = 0; $i -lt $groups[0].length; $i++){

			#GET THIS CHARACTER
			$thisChar = $groups[0].substring($i, 1);

			#IF THIS CHAR IS WITHIN GROUP 1 + 2 (CASE INSENSITIVE)
			if($groups[1] -cmatch $thisChar -And $groups[2] -cmatch $thisChar){

				#ADD THIS CHARACTER'S PRIORITY TO THE TOTAL
				$total += Get-Priority $thisChar;
				break;
			}
		}

		#CLEAR GROUPS READY FOR NEXT BATCH
		$groups = @();
	}
}

#OUTPUT THE ANSWER
$total;