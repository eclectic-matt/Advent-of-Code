<# POWERSHELL ADVENT OF CODE 2022 - DAY 4, PART 2 #>

#GET INPUT
$file = "input.txt";

#READ FILE INTO VARIABLE
$content = Get-Content -Path $file;

#INIT TOTAL
$total = 0;

#ITERATE THROUGH LINES IN FILE
foreach($line in $content){

	#DEBUG
	#Write-Host $line;

	#SPLIT FIRST ASSIGNMENTS INTO PARTS
	$firstHalf = $line.substring(0,$line.IndexOf(","));
	$firstLower = [int]$firstHalf.substring(0,$firstHalf.IndexOf("-"));
	$firstUpper = [int]$firstHalf.substring($firstHalf.IndexOf("-") + 1);
	#SPLIT SECOND ASSIGNMENTS INTO PARTS
	$secondHalf = $line.substring($line.IndexOf(",") + 1);
	$secondLower = [int]$secondHalf.substring(0,$secondHalf.IndexOf("-"));
	$secondUpper = [int]$secondHalf.substring($secondHalf.IndexOf("-") + 1);

	#CREATE RANGES
	$firstRange = ($firstLower .. $firstUpper);
	$secondRange = ($secondLower .. $secondUpper);

	#CHECK RANGE INTERSECTION
	$matching = ($firstRange | Where-Object{$secondRange -contains $_});

	#IF THERE ARE OVERLAPPING VALUES
	if($matching.length -gt 0){

		#INCREMENT TOTAL
		$total += 1;
	}
}

#OUTPUT ANSWER
$total;