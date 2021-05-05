<?php

require_once 'Game.php';
require_once 'Messages.php';


/*
*As long that Player want to Play the Game Is On
*/
$anotherGame = false;
do {
    $anotherGame = startGame();
} while ($anotherGame);

goodByeMsg();

function startGame(){
    HelloUser();
    $game = new Game();
    $game->startPlay();
    return anotherGame();
}

function anotherGame(){
    $answer = readline("Do you want to play another game ? Y/N \n");
    $startAgain = false;
    switch(strtoupper($answer)) { 
        case 'Y' :
            $startAgain = true;
            break;
        case 'N':
            $startAgain = false;
            break;
        default:
            NewGame();
            anotherGame();
    }
    return $startAgain;    
}



