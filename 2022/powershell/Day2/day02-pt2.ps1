<# POWERSHELL ADVENT OF CODE - DAY 2, PART 2 #>

#INPUT FILE
$file = "input.txt";

#READ FILE INTO VARIABLE
$content = Get-Content -Path $file;

#INIT TOTAL
$total = 0;

#RULES - FOR THE OPPONENT'S SHAPES (WHAT WILL LOSE/DRAW/WIN)
$a = @{'name'='rock'; 'points'=1; 'X'='C'; 'Y'='A'; 'Z'='B'};
$b = @{'name'='paper'; 'points'=2; 'X'='A'; 'Y'='B'; 'Z'='C'};
$c = @{'name'='scissors'; 'points'=3; 'X'='B'; 'Y'='C'; 'Z'='A'};
#AND POINTS FOR EACH OUTCOME
$x = @{'name'='loss'; 'points'=0};
$y = @{'name'='draw'; 'points'=3};
$z = @{'name'='win'; 'points'=6};
#STORE INTO COMPLETE RULES OBJECT
$rules = @{'A'=$a; 'B'=$b; 'C'=$c; 'X'=$x; 'Y'=$y; 'Z'=$z};

#ITERATE THROUGH LINES IN THE INPUT FILE
foreach($line in $content){
	
	#SPLIT INTO OPPONENT AND PLAYER
	$split = $line.split(" ");
	$opponent = $split[0];
	$result = $split[1];

	#ADD THE POINTS FOR THIS RESULT
	$total += $rules.$result.points;

	#GET THE CHARACTER WE WILL ACTUALLY PLAY
	$char = $rules.$opponent.$result;

	#THEN ADD THE POINTS FOR THIS SHAPE
	$total += $rules.$char.points;
}

#OUTPUT ANSWER
Write-Host (-join("TOTAL POINTS: ",$total));