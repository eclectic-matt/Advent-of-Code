<?php

//ADVENT OF CODE 2022 - DAY 12

/*
	NOTES:
	https://medium.com/@nicholas.w.swift/easy-a-star-pathfinding-7e6689c7f7b2
	https://github.com/Nexii-Malthus/phpPathfinding/blob/master/libPathfinding.php
	https://stackoverflow.com/questions/4609028/simple-pathfinding-in-php
	https://www.redblobgames.com/pathfinding/a-star/implementation.html#python-astar
*/

//OPEN FILE HANDLE (READ)
$handle = fopen("input.txt", "r");

//INIT THE PATH ARRAY
$path = array();
//STEPS TAKEN CAN BE count($path) - 1

//DEAD END ARRAY
$deadEnds = array();

//INIT GRID ARRAY
$grid = array();
$row = 0;

//BUILD THE GRID (2D ARRAY)
if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//THE ROW IS THE SPLIT LINE (FILTER TO REMOVE "\n" ELEMENTS AT THE END)
		$grid[$row] = array_filter(str_split($line),function($v){
			return $v !== "\n";
		});
		//INCREMENT ROW
		$row++;
	}
}

//FIND STARTING COORDINATES
foreach($grid as $rowId => $row){
	foreach($row as $colId => $col){
		if($col === 'S'){
			$path[] = array($rowId, $colId);
		}
	}
};

//SET THE CURRENT ELEVATION (CELL SAYS "S" BUT THIS IS "a")
$currentElevation = 'a';
echo 'Current elevation is: ' . $currentElevation . '<br>';
echo 'The current coords are: (' . 
	$path[0][0] . ', ' . $path[0][1] . 
') = ' . $grid[ $path[0][0] ][ $path[0][1] ] . '<br>';

$round = 0;
$roundLimit = 10000;
$currentLocation = array(20, 0);
$previousLocation = array(20,0);

while (
	($currentElevation !== 'E') and
	($round < $roundLimit)
){

	$currentLocation = processMove($currentLocation, $grid, $path);
	if($currentLocation === $previousLocation){
		echo '<b>REVISITING A LOCATION - WORK BACK!</b><br>';
		//REMOVE FROM PATH (TWICE)
		$deadEnd = array_pop($path);
		$deadEnds[] = $deadEnd;
		//array_pop($path);
	}else{
		echo '<b>NEW LOCATION - CONTINUE</b><br>';
		$previousLocation = $currentLocation;
	}
	$currentElevation = $grid[$currentLocation[0]][$currentLocation[1]];
	echo '<h2>Current location is (' . $currentLocation[0] . ', ' . $currentLocation[1] . ') with elevation = ' . $currentElevation . '</h2>';
	$round++;
}

if($grid[$currentLocation[0]][$currentLocation[1]] == 'E'){
	echo '<h1>HOLY SHIT! REACHED THE CURRENT LOCATION!!!!</h1>';
}
/*
echo '<pre>';
	var_dump($path);
echo '</pre>';

die();
*/

function priority_add(&$queue, $item){
	//CALCULATE HEURISTIC FOR ITEM
	$item['h'] = 0;

	//SORT QUEUE BY HEURISTICS
	uasort($queue, 'priority');
}

function processMove($current, $grid, &$path){
	
	global $deadEnds;
	list($x, $y) = $current;
	$currentElevation = ($grid[$x][$y] === 'S' ? 'a' : $grid[$x][$y]);
	//global $currentElevation;

	//CHECK LEFT MOVE
	if($y > 0){
		//LEFT GRID CELL EXISTS
		$adjacent = $grid[$x][$y - 1];
		$diff = ord($adjacent) - ord($currentElevation);
		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			echo 'LEFT MOVE POSSIBLE<br>';
			$adjacentLocation = array($x, $y - 1);
			if(in_array($adjacentLocation,$path)){
				echo 'LEFT ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				echo 'LEFT IS A DEAD END - IGNORE<br>';
			}else{
				echo 'ADDING LEFT TO PATH<br>';
				$path[] = $adjacentLocation;
				return $path[count($path) - 1];
			}
		}else{
			echo 'LEFT ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		echo 'NO LEFT CELL<br>';
	}

	//CHECK RIGHT MOVE
	if($y < count($grid[$x]) - 1){
		//RIGHT GRID CELL EXISTS
		$adjacent = $grid[$x][$y + 1];
		$diff = ord($adjacent) - ord($currentElevation);
		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			echo 'RIGHT MOVE POSSIBLE<br>';
			$adjacentLocation = array($x, $y + 1);
			if(in_array($adjacentLocation,$path)){
				echo 'RIGHT ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				echo 'RIGHT IS A DEAD END - IGNORE<br>';
			}else{
				echo 'ADDING RIGHT TO PATH<br>';
				$path[] = $adjacentLocation;
				return $path[count($path) - 1];
			}
		}else{
			echo 'RIGHT ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		echo 'NO RIGHT CELL<br>';
	}
	
	//CHECK UP MOVE
	if($x > 0){
		//UP GRID CELL EXISTS
		$adjacent = $grid[$x - 1][$y];
		$diff = ord($adjacent) - ord($currentElevation);
		echo '<em>Check up - elevation=' . $adjacent . ' so diff=' . $diff . '</em><br>';

		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			echo 'UP MOVE POSSIBLE<br>';
			$adjacentLocation = array($x - 1, $y);
			if(in_array($adjacentLocation,$path)){
				echo 'UP ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				echo 'UP IS A DEAD END - IGNORE<br>';
			}else{
				echo 'ADDING UP TO PATH<br>';
				$path[] = array($x - 1, $y);
				return $path[count($path) - 1];
			}
		}else{
			echo 'UP ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		echo 'NO UP CELL<br>';
	}
	
	//CHECK DOWN MOVE
	if($x < count($grid) - 1){
		//DOWN GRID CELL EXISTS
		$adjacent = $grid[$x + 1][$y];
		$diff = ord($adjacent) - ord($currentElevation);
		echo '<em>Check down - elevation=' . $adjacent . ' so diff=' . $diff . '</em><br>';
		
		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			echo 'DOWN MOVE POSSIBLE<br>';
			$adjacentLocation = array($x + 1, $y);
			if(in_array($adjacentLocation,$path)){
				echo 'DOWN ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				echo 'DOWN IS A DEAD END - IGNORE<br>';
			}else{
				echo 'ADDING DOWN TO PATH<br>';
				$path[] = $adjacentLocation;
				return $path[count($path) - 1];
			}
		}else{
			echo 'DOWN ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		echo 'NO DOWN CELL<br>';
	}

	//RETURN THE LAST PATH LOCATION
	return $path[count($path) - 1];
}


echo '<ul>';
foreach($path as $id => $location){
	echo '<li>Visit ' . $id . ' = (' . $location[0] . ', ' . $location[1] . ')</li>';
}
echo '</ul>';


echo '<pre>';
foreach($grid as $rowId => $row){
	foreach($row as $colId => $col){
		//PRINT # OR _ DEPENDING ON VISITED
		if(in_array(array($rowId, $colId), $path)){
			echo '#';
		}else{
			echo '_';
		}
	}
	//NEW ROW
	echo '<br>';
};
echo '</pre>';

die();
/*
die();
echo '<pre>';
	var_dump($grid);
echo '</pre>';
*/

$openList = array();

$node = array();
$node['x'] = 0;
$node['y'] = 0;
$node['f'] = 3;
$openList[] = $node;

$node = array();
$node['x'] = 1;
$node['y'] = 1;
$node['f'] = 4;
$openList[] = $node;

$node = array();
$node['x'] = 2;
$node['y'] = 2;
$node['f'] = 8;
$openList[] = $node;

uasort($openList, 'priority');
echo '<pre>';
	var_dump($openList);
echo '</pre>';
die();

function heuristic($start, $current){
	return ( abs($a[0] - $b[0]) + abs($a[1] - $b[1]) );
}

function aStarSearch($grid, $start, $goal){
	
	//INIT LISTS
	$openList = array();
	$closedList = array();

	//PUT THE START LOCATION ONTO THE OPEN LIST
	$openList[] = $start;

	//WHILE THERE ARE STILL LOCATIONS IN THE OPEN LIST
	while (count($openList) > 0){

		//GET THE HIGHEST PRIORITY FROM THE OPEN LIST
		$current = array_pop($openList);
		//SORT THE LIST
		uasort($openList, 'priority');
	}
}

function priority($a, $b){
	if($a['f'] == $b['f']){
		return 0;
	}
	return ($a['f'] < $b['f'] ? 1 : -1);
}

class Node{
	public int $f;	//the total cost of the node
	public int $g;	//the distance from current -> start node
	public int $h;	//the heuristic (estimate from current -> end node)
	public int $x;	//the x position
	public int $y;	//the y position
	public int $w;	//the weight

	public function __construct($x, $y, $w){
		$this->x = $x;
		$this->y = $y;
		$this->w = $w;
	}
}

class PQueue {
	public $queue;

}
/*
def a_star_search(graph: WeightedGraph, start: Location, goal: Location):
    frontier = PriorityQueue()
    frontier.put(start, 0)
    came_from: dict[Location, Optional[Location]] = {}
    cost_so_far: dict[Location, float] = {}
    came_from[start] = None
    cost_so_far[start] = 0
    
    while not frontier.empty():
        current: Location = frontier.get()
        
        if current == goal:
            break
        
        for next in graph.neighbors(current):
            new_cost = cost_so_far[current] + graph.cost(current, next)
            if next not in cost_so_far or new_cost < cost_so_far[next]:
                cost_so_far[next] = new_cost
                priority = new_cost + heuristic(next, goal)
                frontier.put(next, priority)
                came_from[next] = current
    
    return came_from, cost_so_far
	*/