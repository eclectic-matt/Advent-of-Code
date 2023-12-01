<?php

//ADVENT OF CODE 2022 - DAY 12

//http://localhost/Advent2022/php/Day12/Day12.php

/*
	NOTES:
	https://medium.com/@nicholas.w.swift/easy-a-star-pathfinding-7e6689c7f7b2
	https://github.com/Nexii-Malthus/phpPathfinding/blob/master/libPathfinding.php
	https://stackoverflow.com/questions/4609028/simple-pathfinding-in-php
	https://www.redblobgames.com/pathfinding/a-star/implementation.html#python-astar

	https://web.archive.org/web/20171022224528/http://www.policyalmanac.org/games/aStarTutorial.htm
	https://web.archive.org/web/20171019182159/http://www.policyalmanac.org/games/heuristics.htm
*/



//ARRAY TEST
/*
$arr = array(0, 1, 2, 3, 4, 5, 6);
array_splice($arr, 2,0,9);
var_dump($arr);
die();
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

//INIT ROUND AND ROUND LIMIT
$round = 0;
$roundLimit = 10000;
//INIT START/END LOCATION (CALCULATED LATER)
$currentLocation = array(20, 0);
$previousLocation = array(20,0);
//PREPARE START/END LOCATION
$startLocation = null;
$endLocation = null;
//SET THE CURRENT ELEVATION (CELL SAYS "S" BUT THIS IS "a")
$currentElevation = 'a';

//BUILD THE GRID (2D ARRAY)
if ($handle) {
	//READ FILE LINE BY LINE
	while (($line = fgets($handle)) !== false) {

		//THE ROW IS THE SPLIT LINE (FILTER TO REMOVE "\n" ELEMENTS AT THE END)
		$grid[$row] = array_filter(str_split($line),function($v){
			return $v !== "\n";
		});

		/*
		//CONVERT INTO NODES?
		foreach($grid[$row] as $col => $cell){
			$node = new Node($row, $col, 1, 0, 0);
			$grid[$row] = $node;
		}
		*/

		//INCREMENT ROW
		$row++;
	}
}

//---

//FIND STARTING/ENDING LOCATION
foreach($grid as $rowId => $row){
	foreach($row as $colId => $col){
		if($col === 'S'){
			$path[] = array($rowId, $colId);
			$startLocation = array($rowId, $colId);
		}else if($col === 'E'){
			$endLocation = array($rowId, $colId);
		}
	}
}
echo 'The Start Location is: ' . implode(',', $startLocation) . '<br>';
echo 'The End Location is: ' . implode(',', $endLocation) . '<br>';

//---

while (
	($currentElevation !== 'E') and
	($round < $roundLimit)
){
	//RUN "processMove" TO GET THE NEW CURRENT LOCATION
	$currentLocation = processMove($currentLocation, $grid, $path);
	
	if($currentLocation === $previousLocation){
	
		//REMOVE FROM PATH
		$deadEnd = array_pop($path);
		$deadEnds[] = $deadEnd;
	}else{
		
		//STORE THE PREVIOUS LOCATION
		$previousLocation = $currentLocation;
	}
	
	//GET THE CURRENT ELEVATION (COULD NOW BE "E")
	$currentElevation = $grid[$currentLocation[0]][$currentLocation[1]];
	
	//INCREMENT ROUND
	$round++;
}

//---

if($grid[$currentLocation[0]][$currentLocation[1]] == 'E'){

	echo '<h1>HOLY SHIT! REACHED THE END LOCATION!!!!</h1>';
	echo '<b>PATH LENGTH: ' . count($path) . '</b><br>';
	//1525 too high (BRUTE FORCE)
}

//OUTPUT GRID TO SCREEN
outputGrid($grid, $path);

//OUTPUT PATH INFO
foreach($path as $id => $location){

	echo '<h2>At path ' . $id . ' (' . implode(', ',$location) . ') we have:</h2>';
	//echo '<b>Distance from start: ' . calcDistance(array_slice($path,0,$id - 1,true)) . '</b><br>';
	
	$startDistance = calcDistance(array_slice($path,0,$id,true));
	$heuristic = calcHeuristic($location, $endLocation);
	echo 'Distance from start: ' . $startDistance . '<br>';
	echo 'Heuristic: ' . $heuristic . '<br>';
	echo '<b>TOTAL COST: ' . ($heuristic + $startDistance) . '</b>';
	echo '<br><hr><br>';
}




//=====================
//UTILITIES
//=====================

function calcHeuristic($current, $end){

	if(!is_array($current)){

		//THE "NON-DIAGONAL" VERSION (MANHATTAN METHOD)
		return (abs($current[0] - $end[0]) + abs($current[2] - $end[1]));
	}else{

		//THE "NON-DIAGONAL" VERSION (MANHATTAN METHOD)
		return (abs($current[0] - $end[0]) + abs($current[1] - $end[1]));
	}
}

function calcDistance($currentPath){
	
	//RETURN THE LENGTH OF THE CURRENT PATH?
	return count($currentPath);

	//----

	//REDUCE THE ARRAY BY SUMMING THE "H" VALUES ON THE CURRENT PATH
	return array_reduce($currentPath, function($carry, $item){

		global $endLocation;
		//SUM THE CALCULATED HEURISTIC FOR EACH ITEM IN THE CURRENT PATH
		$carry += calcHeuristic($item, $endLocation);
	},0);
}

/**
 * Output the grid to the screen.
 */
function outputGrid($grid, $path){

	echo '<pre>';
	foreach($grid as $rowId => $row){
		foreach($row as $colId => $col){
			
			if($grid[$rowId][$colId] === 'E'){

				echo '<span style="color: red;">E</span>';

			}else if ($grid[$rowId][$colId] === 'S'){

				echo '<span style="color: red;">S</span>';

			}else if(in_array(array($rowId, $colId), $path)){

				//PRINT # OR _ DEPENDING ON VISITED
				$curPath = array_search(array($rowId,$colId),$path);
				if($curPath > 0){
					//GET PREV
					$prevPath = $path[$curPath - 1];
				}
				$curEl = $grid[$rowId][$colId];
				$preEl = $grid[$prevPath[0]][$prevPath[1]];
				$color = floor(0xfffff * (ord($curEl) / 255));
				echo '<span style="background-color: #' . $color . '" title="(' . $rowId . ',' . $colId . ') = vist #' . $curPath . '">';
				if($curEl > $preEl){
					echo '^';
				}else if ($curEl == $preEl){
					echo '=';
				}else{
					echo 'V';
				}
				echo '</span>';
				//echo '#';
			}else{
				echo '_';
			}
		}
		//NEW ROW
		echo '<br>';
	}
	echo '</pre>';
}
















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
			//echo 'LEFT MOVE POSSIBLE<br>';
			$adjacentLocation = array($x, $y - 1);
			if(in_array($adjacentLocation,$path)){
				//echo 'LEFT ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				//echo 'LEFT IS A DEAD END - IGNORE<br>';
			}else{
				//echo 'ADDING LEFT TO PATH<br>';
				$path[] = $adjacentLocation;
				return $path[count($path) - 1];
			}
		}else{
			//echo 'LEFT ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		//echo 'NO LEFT CELL<br>';
	}

	//CHECK RIGHT MOVE
	if($y < count($grid[$x]) - 1){
		//RIGHT GRID CELL EXISTS
		$adjacent = $grid[$x][$y + 1];
		$diff = ord($adjacent) - ord($currentElevation);
		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			//echo 'RIGHT MOVE POSSIBLE<br>';
			$adjacentLocation = array($x, $y + 1);
			if(in_array($adjacentLocation,$path)){
				//echo 'RIGHT ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				//echo 'RIGHT IS A DEAD END - IGNORE<br>';
			}else{
				//echo 'ADDING RIGHT TO PATH<br>';
				$path[] = $adjacentLocation;
				return $path[count($path) - 1];
			}
		}else{
			//echo 'RIGHT ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		//echo 'NO RIGHT CELL<br>';
	}
	
	//CHECK UP MOVE
	if($x > 0){
		//UP GRID CELL EXISTS
		$adjacent = $grid[$x - 1][$y];
		$diff = ord($adjacent) - ord($currentElevation);
		//echo '<em>Check up - elevation=' . $adjacent . ' so diff=' . $diff . '</em><br>';

		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			//echo 'UP MOVE POSSIBLE<br>';
			$adjacentLocation = array($x - 1, $y);
			if(in_array($adjacentLocation,$path)){
				//echo 'UP ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				//echo 'UP IS A DEAD END - IGNORE<br>';
			}else{
				//echo 'ADDING UP TO PATH<br>';
				$path[] = array($x - 1, $y);
				return $path[count($path) - 1];
			}
		}else{
			//echo 'UP ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		//echo 'NO UP CELL<br>';
	}
	
	//CHECK DOWN MOVE
	if($x < count($grid) - 1){
		//DOWN GRID CELL EXISTS
		$adjacent = $grid[$x + 1][$y];
		$diff = ord($adjacent) - ord($currentElevation);
		//echo '<em>Check down - elevation=' . $adjacent . ' so diff=' . $diff . '</em><br>';
		
		//AS LONG AS THE ELEVATION IS LESS THAN 1
		if($diff <= 1){
			//echo 'DOWN MOVE POSSIBLE<br>';
			$adjacentLocation = array($x + 1, $y);
			if(in_array($adjacentLocation,$path)){
				//echo 'DOWN ALREADY VISITED - IGNORE<br>';
			}else if(in_array($adjacentLocation,$deadEnds)){
				//echo 'DOWN IS A DEAD END - IGNORE<br>';
			}else{
				//echo 'ADDING DOWN TO PATH<br>';
				$path[] = $adjacentLocation;
				return $path[count($path) - 1];
			}
		}else{
			//echo 'DOWN ELEVATION NOT POSSIBLE (' . ord($adjacent) . ')<br>';
		}
	}else{
		//echo 'NO DOWN CELL<br>';
	}

	//RETURN THE LAST PATH LOCATION
	return $path[count($path) - 1];
}



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

	public int $f;	//the total cost of the node ($g + $h)
	public int $g;	//the distance from current -> start node
	public int $h;	//the heuristic (estimate from current -> end node)
	public int $x;	//the x position
	public int $y;	//the y position
	public int $w;	//the weight

	/**
	 * Construct a new node.
	 * @param int $x The x position of the node.
	 * @param int $y The y position of the node.
	 * @param int $w The weight to travel to this node.
	 * @param int $prevCost The cost to get up to this node.
	 * @param \Node $end The end location node (for heuristic calc).
	 * @return void No output.
	*/
	public function __construct($x, $y){ // $w, $prevCost, $end){

		//STORE THE X-POS, Y-POS, AND CURRENT WEIGHT (DISTANCE TO PREV)
		$this->x = $x;
		$this->y = $y;
		//$this->w = $w;
		//THE NEW DISTANCE ADDS THE CURRENT WEIGHT
		//$this->g = $prevCost + $this->w;
		//CALCULATE "H" (AND THEREFORE "F")
		//$this->calcHeuristic($end);
	}

	/**
	 * Calculate the heuristic (estimated cost to move to the end) for this node.
	 * @param \Node $end The end node.
	 * @return The calculated heuristic.
	 */
	public function calcHeuristic($end){
		
		//RECALC HEURISTIC
		$this->h = (abs($this->x - $end[0]) + abs($this->y - $end[1]));
		//RECALC TOTAL COST
		$this->f = $this->g + $this->h;
		//RETURN THE CALC
		return $this->h;
	}

	/**
	 * Gets the cost to travel to this node.
	 * @return $int The cost.
	 */
	public function getCost(){

		//RETURN VALUE
		return $this->f;
	}
}


class PQueue {

	public $queue;

	public function __construct(){
		$this->queue = array();
	}

	public function put($item){
		array_push($this->queue,$item);
	}

	public function get(){

		$minH = 10000000;
		$return = $this->queue[0];
		foreach($this->queue as $item){
			if($item->getCost() < $minH){
				$minH = $item->f;
				$return = $item;
			}
		}
		return $return;
	}

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