<# POWERSHELL ADVENT OF CODE 2022 - DAY 4 #>

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

		#GET THE MIN AND THE MAX FROM THE MATCHING CHARS
		$matchMin = [int]($matching | measure -Minimum).Minimum;
		$matchMax = [int]($matching | measure -Maximum).Maximum;
		#OUTPUT MIN & MAX
		#Write-Host (-join("MIN: ",$matchMin," MAX: ",$matchMax));

		#IS THE MATCH THE FIRST RESULT?
		if( ($matchMin -eq $firstLower) -And ($matchMax -eq $firstUpper) ){
			
			#Write-Host (-join($firstHalf," is within ",$secondHalf)); 
			#INCREMENT TOTAL
			$total += 1;

		#IS THE MATCH THE SECOND RESULT?
		}elseif ( ($matchMin -eq $secondLower) -And ($matchMax -eq $secondUpper) ){
			
			#Write-Host (-join($secondHalf," is within ",$firstHalf)); 
			#INCREMENT TOTAL
			$total += 1;
		}else{

			#NO OVERLAP
			#Write-Host (-join("NO OVERLAP: ",$line)); 
		}

		#Write-Host "============";

	}else{

		#NO OVERLAP
		#Write-Host (-join("NO MATCHING: ",$line));
		#Write-Host "============";
	}
}

#OUTPUT ANSWER
$total;

$processed;

<#
	$myArray = [int[]]5,66,4,33,2,9,9,12
	$minvalue=[int]($myArray | measure -Minimum).Minimum
	$myArray.IndexOf($minvalue)
#>