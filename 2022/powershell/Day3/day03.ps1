<# POWERSHELL - ADVENT OF CODE 2022 - DAY 3 #>

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

#ITERATE THROUGH LINES IN THE INPUT FILE
foreach($line in $content){
	
	#GET THE MIDPOINT
	$mid = ($line.length / 2);
	$compOne = $line.substring(0,$mid);
	$compTwo = $line.substring($mid, $mid);
	
	#ITERATE THROUGH CHARS IN $compOne
	for($i = 0; $i -lt $mid; $i++){

		#GET THIS CHARACTER
		$thisChar = $compOne.substring($i, 1);
		
		#CHECK IF $compTwo MATCHES THIS CHAR (CASE INSENSITIVE)
		if($compTwo -cmatch $thisChar){

			#UTILITY TO GET PRIORITY VALUE
			$priority = Get-Priority $thisChar;
			#ADD THIS TO THE TOTAL
			$total += $priority;
			#BREAK THIS FOR LOOP
			break;
		}
	}
}

#OUTPUT THE ANSWER
$total;

#DISPLAY CHARS AND CHAR CODES
#$chars = [char[]]([char]'A'..[char]'z')
#[char[]]([char]'A'..[char]'z') | ForEach-Object { -join([int]$_ , " => " , $PSItem)}