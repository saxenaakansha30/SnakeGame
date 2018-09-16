<?php

namespace Src\SnakeGame;

/**
 * Class to move snake;
 */
 
class Snake extends Box {
  
  private $position = array();

  private $rowCenter;

  private $colCenter;
  
  private $snakeLength;
  
  private $movement;

  private $food = array();
  
  private $ateFood = False;

  private $gameInit = True;
  
  function __construct(int $rowSize, int $colSize) {
    parent::__construct($rowSize,$colSize);
  }
  
  function initialSnakePositionInCenter(): array {
    $this->rowCenter = $this->getProperties('rowMax')/2;
    $this->colCenter = $this->getProperties('colMax')/2;
    $this->position[] = [
    'col' => $this->colCenter,
    'row' => $this->rowCenter,
    ];
    $this->box[$this->colCenter][$this->rowCenter] = 'x';
    return $this->box;
  }
  
  function setMovement(string $move) : void {
	$this->movement = $move;
  }
  
  function moveSnake() : array {
	$gameStarted = True;
    switch($this->movement) {
	  case 'left':
	  $newHeadRow = $this->position[0]['row'] + 1;
	  $newHeadCol = $this->position[0]['col'];
	    break;
	  case 'right':
	  $newHeadRow = $this->position[0]['row'] - 1;
	  $newHeadCol = $this->position[0]['col'];
	    break;
	  case 'up':
	  $newHeadRow = $this->position[0]['row'];
	  $newHeadCol = $this->position[0]['col'] - 1;
	    break;
	  case 'down':
	  $newHeadRow = $this->position[0]['row'];
	  $newHeadCol = $this->position[0]['col'] + 1;
	    break;
	  default:
	    $gameStarted = False;
	}
	
	if($gameStarted) {
	  $newHead = ['col' => $newHeadCol, 'row' => $newHeadRow];
      $this->box[$newHeadCol][$newHeadRow] = 'x';
	  array_unshift($this->position, $newHead);
      $lastElement = count($this->position) - 1;
 
	  if (!$this->snakeEatFood($newHeadCol, $newHeadRow)) { // Unset last element as snake is moved.
        $this->box[$this->position[$lastElement]['col']][$this->position[$lastElement]['row']] = ' ';
        unset($this->position[$lastElement]);
	  }
    }
    return $this->box;
  }
  
  function ifCrashed() {
    $firstCol = $this->position[0]['col'];
    $firstRow = $this->position[0]['row'];
    if (($firstCol == $this->getProperties('colMax')) || ($firstRow == $this->getProperties('rowMax')) || ($firstCol == $this->getProperties('colMin')) || ($firstRow == $this->getProperties('rowMin')))
	  return True;
	else
	  return False;
  }
  
  /**
   * Function to generate the food for snake.
   */
  function generateFood() : array {
    // Generate ramdon column number.
    if ($this->ateFood || $this->gameInit) {
	  $this->gameInit = False; // Game has started.
      $foodCol = random_int(1, $this->getProperties('colMax') - 1);
      for ( $i = 0; $i < count($this->position); $i++) {
	    $snakeRowPositions[] = $this->position[$i]['row'];
	  }
      do {
		$foodRow = random_int(1, $this->getProperties('rowMax') - 1);	
	  } while (in_array($foodRow, $snakeRowPositions));
      $this->food['row'] = $foodRow;
      $this->food['col'] = $foodCol;
    }
    
    $this->box[$this->food['col']][$this->food['row']] = 'x';
    return $this->box;
  }
  
  /**
   * Function to check if snake ate the food or not.
   */
  function snakeEatFood($snakeNewHeadCol, $snakeNewHeadRow) {
    if (($this->food['row'] == $snakeNewHeadRow) && ($snakeNewHeadCol == $this->food['col'])) {
	  $this->ateFood = True;
	  return True;
	} else {
	  $this->ateFood = False;
	  return False;		
	}
  }
  
  /**
   * Function for game score.
   */
  function gameScore() : int {
    return count($this->position) - 1;
  }

}
