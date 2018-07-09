<?php

namespace Src\SnakeGame;

/**
 * @file
 * Class to determine entered keys.
 */
class Keys {
	
  private $up;

  private $down;

  private $left;

  private $right;
  
  private $quit;
  
  function __construct() {
    $this->up = 65; // Character i
    $this->down = 66; // Character k
    $this->left = 67; // Character a
    $this->right = 68; // Character s
  }

  function getKey($key) {
    return $this->$key;
  }

}
