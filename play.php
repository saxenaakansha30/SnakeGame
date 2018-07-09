<?php

/** @file 
 * Main file calling functions for testing
 */

include 'index.php';

use Src\SnakeGame\Keys;
use Src\SnakeGame\Snake;
use React\EventLoop\Factory;
use Src\SnakeGame\Game;

$terminalCols = exec('tput cols'); // Set width of box.
$terminalRows = exec('tput lines'); // Set height of box.
$gameObject = new Game(new Keys(), new Snake($terminalCols, $terminalRows - 1), Factory::create());

$gameObject->initGame(); //Start the game.
