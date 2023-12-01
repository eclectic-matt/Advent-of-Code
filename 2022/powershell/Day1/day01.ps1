<# POWERSHELL ADVENT DAY 1 #>

$file = "input.txt";

#READ FILE INTO VARIABLE (RAW TO PREVENT BREAKING NEW LINES)
$content = Get-Content -Path $file -Raw;
#Write-Host (-join("Content count: ", $content.Count));

#SPLIT INTO INVENTORIES
$inventories = ($content -split "\n\n");
$invCount = $inventories.Count;
#Write-Host (-join("Inventories count: ", $invCount));

#PREPARE ELVES ARRAY
$elves = @();

#ITERATE THROUGH THE INVENTORIES
for($i = 0; $i -lt $invCount; $i++){
	
	#SPLIT THIS INVENTORY INTO ITEMS, PIPE INTO A REDUCER TO GET THIS ELF'S TOTAL
	($inventories[$i] -split "\n") | ForEach-Object {$total=0} {$total += $_};
	#Write-Host (-join("Elf #",$i," has a total of ",$total," calories"));
	#ADD TO THE ELVES ARRAY
	$elves += $total;
}

#PIPE THE ELVES ARRAY INTO THE MEASURE OBJECT CMD AND GET THE MAXIMUM VALUE
$maxCalories = ($elves | Measure-Object -Maximum).Maximum;
Write-Host (-join("Max Calories: ",$maxCalories));