<# POWERSHELL ADVENT OF CODE 2022 - DAY 5 #>

clear

#cmd /k 'cd "C:\Program Files\xampp\htdocs\Advent2022\powershell\Day5\day05.ps1"';

# ANSWER: RTGWZTHLD

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
			#Get-Stacks $stacks;
            $stacks;

            Write-Host "==================";
            for($i = 1; $i -lt 10; $i++){

                #THIS WORKS (HERE)
                Write-Host $stacks.$i;
                #Write-Host ($stacks | Select-Object -Index $i);
            }

            Write-Host "STACK EIGHT IS: $($stacks.8)";

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
		$from = [int]$line.substring($line.IndexOf("from") + 5,1).trim();
		$to = [int]$line.substring($line.IndexOf("to") + 3, 1).trim();

		#Write-Host (-join("MOVE ",$count," FROM ",$from," TO ",$to));
        Write-Host "==========================";
        Write-Host (-join("MOVE ",$count," CRATES FROM STACK ",$from," TO STACK ",$to));
                
        #RUN ONCE PER "COUNT"
		for($i = 1; $i -le $count; $i++){
			
			#Write-Host $stacks.$from;
            
            if($stacks.$from.length -gt 0){
			
                Write-Host "--------";
                Write-Host "MOVE $i / $count";

                #TAKE THE FIRST CRATE FROM THE STACK
                #$crate = $stacks.$from.substring(0,1);
                #$stacks.$from = $stacks.$from.Substring(1, $stacks.$from.Length - 1);
			    #APPEND CRATE TO THE END OF THE STACK
                #$stacks.$to += $crate;
                
                #GET THE LAST CRATE FROM THE STACK
                #$crate = $stacks.$from.substring($stacks.$from.length - 1);
                $crate = $stacks.$from[-1];

                $stackFromBefore = $stacks.$from;
                $stackToBefore = $($stacks.$to);

                #if($to -eq 8){
                
                    #Write-Host "STACK EIGHT - ($stacks.$to)";
                    #Write-Host $stacks.Values[8];#.$to;
                    #Write-Host $stacks.Values | Select-Object -Skip $to;
                    #Write-Host $stacks.Values | Select-Object -Index $to;
                    
                    #$stacks."$to";
                    #$stacks.$to;
                    #write-host ($stacks | Select -ExpandProperty $to)
                    #$stacks | Select -expand $to;            #Select : Property "8" cannot be found.
                    #$stacks | Select-Object -Property 8;     #Select-Object : Cannot convert System.Int32 to one of the following types {System.String, System.Management.Automation.ScriptBlock}
                    #$stacks | Select-Object -Property $to;   #Select-Object : Cannot convert System.Int32 to one of the following types {System.String, System.Management.Automation.ScriptBlock}
                    
                    #Write-Host (Get-Member -InputObject $stacks -Name $to);
                    #Write-Host (Get-Member -InputObject $stacks -Name $to).Value;
                    #Write-Host (Get-Member -InputObject $stacks -Name $to -Force).Value;
                    
                    
                    #Write-Host ($stacks | Select-Object -Property "$to").Value; #
                    #Write-Host ($stacks.PSobject.Properties.name -match "$to");
                    #$stacks | Select-Object $stacks.PSobject.Properties.Name -match "$to" | Where-Object $to;
                #}

                
                #DEBUG OUTPUT
                #Write-Host (-join("MOVE ",$count," = ",$crate," FROM ",$from," TO ",$to));
                #Write-Host (-join("STACK ",$from," (FROM, BEFORE): ",$stacks.$from));
                #Write-Host (-join("STACK ",$to," (TO, BEFORE):   ",$stacks.$to));
                
                #REMOVE THE LAST CRATE FROM THE STACK
                $stacks.$from = $stacks.$from.substring(0, ($stacks.$from.length - 1));
                #$stacks.$from = $stacks.$from[0..-1];
                
                #ADD THAT CRATE TO THE START OF THE STACK
                #$stacks.$to = -join($crate,$stacks.$to);
                
                #ADD THAT CRATE TO THE END OF THE STACK
                #$stacks.$to = -join($stacks.$to, $crate);
                $stacks.$to = $stacks.$to + $crate;

                #$stacks.$from = $stacks.$from.substring(- $stacks.$from.length );

                Write-Host (-join("STACK ",$from,": ",$stackFromBefore," => ",$stacks.$from," - REMOVE ",$crate));
                Write-Host (-join("STACK ",$to,": ",$stackToBefore," => ",$stacks.$to));

                #Write-Host (-join("STACK ",$from," (FROM, AFTER): ",$stacks.$from));
                #Write-Host (-join("STACK ",$to," (TO, AFTER):   ",$stacks.$to));
            }
		}

        Write-Host "--------";
        Get-Stacks $stacks;

	}
}



Write-Host "=========================="
Write-Host " "
Write-Host "FINAL STACKS: "
#DEBUG - OUTPUT STACKS
Get-Stacks $stacks;

Write-Host "`n`n`n`n`n";
$output = "";

for($i = 1; $i -lt 10; $i++){
    
    $stackLen = $stacks.$i.Length;
    if($stackLen -gt 0){
        $output = -join($output, $stacks.$i.Substring($stackLen - 1, 1));
        #Write-Host $stacks.$i.Substring($stackLen - 1, 1);
    }
}


Write-Host "ANSWER IS: $output";

function Get-LastChar {

    param(
		[Parameter(Mandatory=$true)] [String]$string
	)

    #RETURN THE LAST CHAR
    return $string.substring(0, $string.length - 1);
}

function Get-AllButLastChars {

    param(
		[Parameter(Mandatory=$true)] [String]$string
	)

    if($string.length -gt 1){
        
        #RETURN THE ALL BUT THE LAST CHAR
        return $string.substring(0, $string.length - 2);
    
    }else{
        
        #NO REMAINING CHARS
        return "";
    }
}

function Get-FirstChar {

    param(
		[Parameter(Mandatory=$true)] [String]$string
	)

    #RETURN THE FIRST CHAR
    return $string.substring(0, 1);
}

function Get-AllButFirstChars {

    param(
		[Parameter(Mandatory=$true)] [String]$string
	)


    if($string.length -gt 1){
        
        #RETURN THE ALL BUT THE LAST CHAR
        return $string.substring(1);
    
    }else{
        
        #NO REMAINING CHARS
        return "";
    }
}