<# POWERSHELL ADVENT OF CODE 2022 - DAY 5 #>


function Get-Stacks{
	param(
		[Parameter(Mandatory=$true)] [System.Array]$stacks
	)
	$stacks | ForEach-Object { $_ }
}

#GET INPUT
$file = "input.txt";

#READ FILE INTO VARIABLE
$content = Get-Content -Path $file;

#INIT TOTAL
$total = 0;
#FLAG PROCESSING STACKS
$processStacks = $true;
#INIT STACKS
$stacks = @{1=$null; 2=$null; 3=$null; 4=$null; 5=$null; 6=$null; 7=$null; 8=$null; 9=$null;};

#ITERATE THROUGH LINES IN FILE
foreach($line in $content){

	#ARE WE PROCESSING THE STACKS?
	if($processStacks){

		#FIRST PASS - PROCESS INITIAL STACKS
		#Write-Host $line;
		
		#HAVE WE REACHED A BLANK LINE?
		if([string]::IsNullOrWhitespace($line)){

			#FINISHED STACKS
			$processStacks = $false;
			Write-Host "INITIAL STACKS";
			Write-Host (Get-Stacks $stacks);
		}else{

			#PROCESS AN INITIAL STACK ROW
			$stripped = $line -replace '\s',''

			#CHECK IF ON THE ID LINE (1   2   3  ...)
			if($stripped -match "^\d+$"){

				#Write-Host "REACHED STACK IDENTIFIER ROW";
			}else{

				#NORMAL STACKS LINE
				$stackCount = [math]::floor(($line.length + 1) / 4);

				#ITERATE THROUGH THIS ROW
				for($i = 0; $i -lt $stackCount; $i++){
					
					#START INDEX
					$start = $i * 4;
					#EXTRACT THIS BLOCK
					
					#FIX - SMALLER FINAL BLOCK!
					if($i -eq ($stackCount - 1)){
						
						$block = $line.substring($start, 2);
					}else{
						
						$block = $line.substring($start, 4);
					}
					
					#IF THIS BLOCK IS EMPTY
					if($block.trim() -eq ""){

						#EMPTY CELL
						#Write-Host "EMPTY!";

					#IF THIS BLOCK STARTS WITH A [
					}elseif($block[0] -eq "["){
						
						#ADD 1 TO GET THE STACK NUMBER 
						$stackIndex = $i + 1;

						#STORE IN THIS STACK
						$stacks.$stackIndex += $block[1];
					}
				}
			}
		}

	}else{

		#SECOND PASS - PROCESS MOVEMENT
		
		#SPLIT INTO PARTS 
		$count = [int]$line.substring($line.IndexOf("move") + 5,1);
		$from = [int]$line.substring($line.IndexOf("from") + 5,1);
		$to = [int]$line.substring($line.indexof("to") + 3, 1);
		Write-Host (-join("MOVE ",$count," FROM ",$from," TO ",$to));

		for($i = 0; $i -lt $count; $i++){
			
			Write-Host $stacks.$from;
			$crate = $stacks.$from.substring(0,1);
			$stacks.$to += $crate;
			$stacks.$from = $stacks.$from.substring(- $stacks.$from.length );
		}

	}
}

#DEBUG - OUTPUT STACKS
Get-Stacks $stacks;