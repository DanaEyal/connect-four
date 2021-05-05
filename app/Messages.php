<?php


/**
 * Game.php
 */

function selectRandPlayerMsg($current_player){
        echo "\nPlayer #".$current_player ." Randomly Selected To Play First\n";
}

function winningMsg($current_player){
    echo "Congratulations!!! Player : ". $current_player ." won !!!!!! \n";
} 
function noWinningMsg(){
    echo "The board is full !!!!! \nUnfortunately no one won \n";
}
function columnIsFullMsg(){
    echo "The column you selected is already full. \n Please select another column\n";
}
function invalidInputMsg(){
    echo "Please Type A Valid Input : 1,2,3,4,5,6,7\n";
}
function readlineUserInputMsg($current_player){
    return("Player #$current_player Please Choose column (1-7) to drop the discs ? ");
}


/**
 * Play.php
 */

function HelloUser(){
    echo "\nWelcome to Connect Four Game\n";
}

function goodByeMsg(){
    echo "\nIt Was My Pleasure Playing with you :) Good Bye \n";
}

function NewGame(){
    echo "Pleasy Type Y or N\n";
}

