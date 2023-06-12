<?php

$width = 20;
$height = 10;
$board = array_fill(0, $height, array_fill(0, $width, ' '));


$snake = array(
    array(5, 5),  // head
    array(4, 5),  // body
    array(3, 5)   // tail
);
$direction = 'right';
$score = 0;
$isGameOver = false;


function drawBoard() {
    global $board, $width, $height, $snake, $score, $isGameOver;


    system('clear');

    // Draw the snake
    foreach ($snake as $segment) {
        $x = $segment[0];
        $y = $segment[1];
        $board[$y][$x] = 'O';
    }

    // Draw the food
    $foodX = $board[0][0] !== ' ' ? -1 : rand(0, $width - 1);
    $foodY = $board[0][0] !== ' ' ? -1 : rand(0, $height - 1);
    $board[$foodY][$foodX] = 'X';

    // Draw the board
    echo "Score: $score\n";
    echo str_repeat('-', $width + 2) . "\n";
    for ($y = 0; $y < $height; $y++) {
        echo '|';
        for ($x = 0; $x < $width; $x++) {
            echo $board[$y][$x];
        }
        echo "|\n";
    }
    echo str_repeat('-', $width + 2) . "\n";

    // Game over message
    if ($isGameOver) {
        echo "Game Over!\n";
    }
}

// Function to move the snake
function moveSnake() {
    global $snake, $direction, $width, $height, $isGameOver;

    // Get the current head position
    $head = $snake[0];
    $x = $head[0];
    $y = $head[1];

    // Determine the new head position based on the direction
    if ($direction === 'up') {
        $y--;
    } elseif ($direction === 'down') {
        $y++;
    } elseif ($direction === 'left') {
        $x--;
    } elseif ($direction === 'right') {
        $x++;
    }

    // Check for collisions with walls or snake's body
    if ($x < 0 || $x >= $width || $y < 0 || $y >= $height || in_array([$x, $y], array_slice($snake, 1))) {
        $isGameOver = true;
        return;
    }

    // Add the new head to the snake
    array_unshift($snake, [$x, $y]);

    // Remove the tail segment if no food was eaten
    if ($x !== $foodX || $y !== $foodY) {
        array_pop($snake);
    }
}

// Function to handle user input
function handleInput() {
    global $direction;

    // Read the user input from the keyboard
    $input = readline('');

    // Change the snake's direction based on the input
    if ($input === 'w' && $direction !== 'down') {
        $direction = 'up';
    } elseif ($input === 's' && $direction !== 'up') {
        $direction = 'down';