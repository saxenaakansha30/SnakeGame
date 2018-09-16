<?php

namespace Src\SnakeGame;

/**
 * @file
 * Class to generate square box.
 */
 
class Box {

  private $rowSize;

  private $colSize;

  private $rowMax;

  private $rowMin = 0;

  private $colMax;

  private $colMin = 0;
  
  protected $box = array();

  protected function __construct(int $rowSize, int $colSize) {
    $this->rowSize = $this->getOddNumber($rowSize);
    $this->colSize = $this->getOddNumber($colSize);
    $this->rowMax = $this->getOddNumber($rowSize) - 1;
    $this->colMax = $this->getOddNumber($colSize) - 1;
  }
  
  /**
   * Function to get properties
   */
  protected function getProperties($prop) {
    return $this->$prop;
  }
  
  function generateBoxMatrix() {
    for ($i = 0; $i <= $this->colMax; $i++) {
      for ($j = 0; $j <= $this->rowMax; $j++) {
        if (($i == $this->colMin)  || ($i == $this->colMax)) {
		  $this->box[$i][$j] = "-";
		} elseif (($j == $this->rowMin)  || ($j == $this->rowMax)) {
		  $this->box[$i][$j] = "|";
	    } else {
		  $this->box[$i][$j] = " ";
		}
      }
	}
	return $this->box;
  }
  
  function showBox($box) {
    for ($i = 0; $i <= $this->colMax; $i++) {
      for ($j = 0; $j <= $this->rowMax; $j++) {
	    print $box[$i][$j];
	  }
	  print "\n";
	}
  }
  
  /**
   * Function to check if row/col boundaries are even if not then make them by
   * decreasing 1.
   */
  public function getOddNumber(int $number) {
    if ($number % 2 == 0) {
	  return $number - 1;
    }
    return $number;
  }

}


