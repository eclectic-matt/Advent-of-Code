<?php

$input = file_get_contents('input.txt', 'r');
$lines = explode("\n", $input);
$grid = array_map(function($row){ return str_split($row,1); }, $lines);
$adjacent = array();

$highlightRow = 1;
$highlightCol = 46;

echo '<h1>Highlighting (' . $highlightRow . ', ' . $highlightCol . ')</h1>';
echo '<pre>';

foreach($grid as $row => $rowData){
	foreach($rowData as $col => $colData){
		if( ($row === $highlightRow) && ($col === $highlightCol) ){
			echo '<span style="background-color: #ffff00; border: 1px solid black;">' . $grid[$row][$col] . '</span>';
		}else{
			if(
				( ($row >= ($highlightRow - 1)) && ($row <= ($highlightRow + 1)) ) &&
				( ($col >= ($highlightCol - 1)) && ($col <= ($highlightCol + 1)) ) 
			){
				echo '<span style="background-color: #00ff00; border: 1px solid black;">' . $grid[$row][$col] . '</span>';
			}else{
				echo $grid[$row][$col];
			}
		}
	}
}
//echo $input;
echo '</pre>';