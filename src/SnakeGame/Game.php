<?php

namespace Src\SnakeGame;

/**
 * Class for runnig the game.
 * This class calls all the methods required for running the game.
 */

Class Game {
  
  private $keysObject;
  
  private $snakeObject;
  
  private $loop;
  
  /**
   * Function to initialize class properties.
   */
  function __construct(Keys $keys, Snake $snakeObject, $loop) {
    $this->keysObject = $keys;
    $terminalCols = exec('tput cols');
    $terminalRows = exec('tput lines');
    $this->snakeObject = $snakeObject; // Set width and height of snake box.
    $this->loop = $loop;
  }
  
  /**
   * Function to run the game.
   */
  function initGame() {
    $this->snakeObject->generateBoxMatrix();
    $box = $this->snakeObject->initialSnakePositionInCenter();
    $stdin = fopen('php://stdin', 'r');
    system('stty -icanon -echo');

    $this->loop->addReadStream($stdin, function ($stdin) {
    $keyFirstChar = ord(fgetc($stdin));

    // Arrow keys pressed.
    if ($keyFirstChar === 27)
    {
      fgetc($stdin);
      $keyThirdChar = ord(fgetc($stdin));
      switch ($keyThirdChar) {
	    case $this->keysObject->getKey('left'):
          $this->snakeObject->setMovement('left');
	      break;
	    case $this->keysObject->getKey('right'):
          $this->snakeObject->setMovement('right');
          break;
	    case $this->keysObject->getKey('up'):
          $this->snakeObject->setMovement('up');
          break;
	    case $this->keysObject->getKey('down'):
          $this->snakeObject->setMovement('down');
          break;
        default:
          $this->loop->removeReadStream($stdin);
          stream_set_blocking($stdin, True);
          fclose($stdin);
	      system('stty echo');
	  }
    }
  });
  
  // Move snake with pressed dimension.
  $timer = $this->loop->addPeriodicTimer(0.2, function() use ($stdin) {
	system('clear');
	$this->snakeObject->showBox($this->snakeObject->moveSnake());
	$this->snakeObject->generateFood();

	// If crashed over timer.
	if ($this->snakeObject->ifCrashed()) {
      $this->loop->removeReadStream($stdin);
	  $this->loop->stop();
      stream_set_blocking($stdin, True);
      fclose($stdin);
   	  system('clear');
	  system('stty echo');
	  echo 'Game Over!' . PHP_EOL;
	  echo 'Sore: ' . $this->snakeObject->gameScore() . PHP_EOL;
	}
  });
  $this->loop->run();
  }
  
}
