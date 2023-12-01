<# POWERSHELL ADVENT OF CODE - DAY 2 #>

$file = "input.txt";

#READ FILE INTO VARIABLE
$content = Get-Content -Path $file;

#INIT TOTAL
$total = 0;

#OBJECT OF SHAPES THAT BEAT OTHER SHAPES
$beats = @{'X'='C'; 'Y'='A'; 'Z'='B'};
#OBJECT OF SHAPES THAT LOSE TO OTHER SHAPES
$loses = @{'X'='B'; 'Y'='C'; 'Z'='A'};
#OBJECT OF POINTS FOR PLAYING EACH SHAPE
$points = @{'X'=1; 'Y'=2; 'Z'=3};

#ITERATE THROUGH LINES IN THE INPUT FILE
foreach($line in $content){
	
	#SPLIT INTO OPPONENT AND PLAYER
	$split = $line.split(" ");
	$opponent = $split[0];
	$player = $split[1];
	
	#ADD THE POINTS FOR PLAYING THIS SHAPE
	$playerPoints = $points.$player;
	$total += $playerPoints + 0;
	
	#GET THE CHARS WHICH WILL BEAT OR LOSE TO THIS SHAPE
	$beatChar = $beats.$player;
	$loseChar = $loses.$player;

	#DID YOU PLAY THE WINNING SHAPE?
	if($beatChar -eq $opponent){

		#ADD 6 POINTS FOR A WIN
		$total += 6;

	#DID YOU PLAY THE LOSING SHAPE?
	}elseif ($loseChar -eq $opponent) {

		#ADD 0 POINTS FOR A LOSS
		$total += 0;

	#ELSE, THIS WAS A DRAW
	}else{

		#ADD 3 POINTS
		$total += 3;
	}

	<#
	WAS GONNA DO THE LAZY WAY
	switch($line){
		"A X" {
			$total += 3 + 1;
		}
		"A Y" {
			$total += 6 + 2;
		}
		"A Z" {
			$total += 0 + 3;
		}
		"B X" {
			$total += 0 + 1;
		}
		"B Y" {
			$total += 3 + 2;
		}
		"B Z" {
			$total += 6 + 3;
		}
		"C X" {
			$total += 6 + 1;
		}
		"C Y" {
			$total += 0 + 2;
		}
		"C Z" {
			$total += 3 + 3;
		}
	}
	#>
}

#OUTPUT ANSWER
Write-Host (-join("TOTAL POINTS: ",$total));