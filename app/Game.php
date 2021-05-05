<?php


require_once 'Board.php';
require_once 'Messages.php';


class Game{

    const ZERO = 0;
    const WIN = 4;
    const FIRST_PLAYER = 1;
    const SECOND_PLAYER = 2;
    

    protected $totalMoves = 0;

    protected $gameOver = false;

    protected $currentPlayer = '0';

    protected $lastRowInsert = -1;
   
    
    public function __construct(){

        $this->initGame();
    }
    
    /**
     * function initializes the board to start playing
     */
    public function initGame(){
        $this->board = new Board();
    }

    /**
     * Main Function- set the hole game 
     * as long as the game status is true - keep playing
     * function validate max moves on board , user selection , full column....     
     * in case of a winning players will recive a win message that print in the console
     */
    public function startPlay(){   

        $this->selectPlayer();
        $this->board->printBoard();

        while(!$this->gameOver){

            //check if board is full
            if($this->reachedMaxMoves() || $this->validateIsFullBoard()){
                noWinningMsg($this->currentPlayer);
                $this->gameOver = true;
                break;
            }
            //  set board with table
            $userMove = $this->selectMove();
            
            //in case that column is not full 
            if(!$this->validateIsFullColumn($userMove)){
                $this->insertMoveToBoard($userMove);
                $this->winCheck($userMove);
                $this->switchPlayer();
            }
        }
    }

    
    /**
     *  Function select random player and print message to inform
     */
    protected function selectPlayer(){
        $this->currentPlayer = rand(1,2);
        selectRandPlayerMsg($this->currentPlayer);
    }

    /**
     * Function asked the player to enter a column that he would like to place his discs
     * after selection set validation to the selection, in case of a bad validation user will notify and asked to selecet again
     * @return $userMove - user selection
     */
    public function selectMove(){
        
        do {
            $userMsg = readlineUserInputMsg($this->currentPlayer);
            $userMove = readline($userMsg);
        } while (!$this->checkValidMove($userMove));

        return $userMove;
    }

    /**
     * Function Insert the selected column into the board with the current player Id 
     * Player 1 as [1] or Player 2 as [2]
     * cell update only if the cell is empty
     * @param $userMove - user selected column to drop his discs
     * @return Board print on the console
     */
    protected function insertMoveToBoard($userMove){
        $current_player = "[$this->currentPlayer]";
        for($row = ($this->board->getRows() - 1) ; $row >-1 ; $row-- ){
            //check if cell is empty
            if($this->board->gameBoard[$row][$userMove-1] == Board::CELL){
                $this->board->gameBoard[$row][$userMove-1] = $current_player;
                $this->lastRowInsert =$row;
                $this->totalMoves++;
                break;
            }
            else{
                continue;
            }
        }
        echo $this->board->printBoard();
    }


     /*
    ************************
    *      Validation      *
    ************************
    */

    /**
     * Function validate the user selection input
     * In case of invalid input -Message print to user to make another selection
     * @param $userMove - user selected column to drop his discs
     * @return Bool - True in case of a valid else return False
     */
    public function checkValidMove($userMove){
       if(!is_numeric($userMove) ||$userMove < 1 || $userMove > Board::COLUMNS){     
            invalidInputMsg($this->currentPlayer);
            return false;
        }
        return true;;
    }

    /**
     * Function verify that the choosen column is not full
     * in case of a full column user message print to user
     * @param $selectedColumn - The user selected column
     * @return Bool - False in case of a full column else return True
     */
    public function validateIsFullColumn($selectedColumn){
        //in case of a full Column
        if($this->board->gameBoard[0][$selectedColumn-1] != Board::CELL){
            columnIsFullMsg($this->currentPlayer);
            return true;
        }
        return false;
    }


    /**
     * Function verify that the board is not full
     * in case of a full Board message print to user
     * @return Bool - False in case of a full Board else return True
     */
    public function validateIsFullBoard(){
        //in case of a full Column
        for($index=0; $index < Board::COLUMNS; $index++){
            //if there is an empty cell
            if($this->board->gameBoard[0][$index] == Board::CELL){
                //board is not full
                return false;
            }
        }///board is full
        return true;
    }

    /**
     * function check if the board is full and no moves left
     * In this case none of the players wins
     */
    protected function reachedMaxMoves(){
        if($this->totalMoves == $this->board->getMaxMoves()){
            return true;
        }
        return false;
    }

   
   /*
    ************************
    * Check Options to Win *
    ************************
    */

    /**
     * Main function that call to all function that check if a player win
     * In case of a winnig function Print winning message and asked if you want to have another game
     * @param $userMove - The user selected column
     */
    protected function winCheck($userMove){
        // Check if we have reached the minimum steps to have a win
        if($this->totalMoves < Board::COLUMNS){
            return false;
        }
        //check vertical Horizontal Positive Diagonal Negative Diagona win
        if(($this->checkVerticalWin($userMove)) 
             || ($this->checkHorizontalWin($userMove))
             || ($this->checkPositiveDiagonalWin($userMove))
             || ($this->checkNegativeDiagonalWin($userMove))
            ){
            //winning message 
            winningMsg($this->currentPlayer);
            $this->gameOver = true;
            return;
        }
    }
 
    /**
     * Function check vartical winning 
     * [X]
     * [X]
     * [X]
     * [X]
     * function run from the point the user choose to type his discs
     * check : first search below the userMove, then search above the userMove
     * In case of sequence 4 of the current player in a column - player won
     * @param $userMove - the user selected column
     * @return Bool - True in case of a win else False
     */
    public function checkVerticalWin($userMove){
        $varticalCounter = self::ZERO;
        $gameBoards =  $this->board->gameBoard; 
        $current_player = "[$this->currentPlayer]";
        for($row = ($this->board->getRows() - 1) ; $row > -1 ; $row-- ){           
            if($varticalCounter == self::WIN){
                return true;
            }
            elseif($gameBoards[$row][$userMove-1] == $current_player){
                $varticalCounter++;
            }
            elseif($row < 2 && $varticalCounter < 1 ){
                return false;
            }
            elseif($gameBoards[$row][$userMove-1] == Board::CELL){
                $varticalCounter = self::ZERO;
                continue;
            }
            else{
                $varticalCounter = self::ZERO;
            }
        }
        return $varticalCounter >= self::WIN ? true : false;
        
    }

    /**
     * Function check Horizontal winning 
     * [X][X][X][X]
     * In case of sequence 4 of the current player in a row - player won
     * @param $userMove - The user selected column
     * @return Bool - True in case of a win else False
     */
    public function checkHorizontalWin($userMove){
        $HorizontalCounter = self::ZERO;
        $gameBoards =  $this->board->gameBoard; 
        $row = $this->lastRowInsert;
        $current_player = "[$this->currentPlayer]";

        for($col = $userMove-1; $col > -1 ; $col-- ){
            if($gameBoards[$row][$col] != $current_player){
                break; 
            }
            $HorizontalCounter++;
        }
        for($col= $userMove; $col < Board::COLUMNS ; $col++){
            if($gameBoards[$row][$col] != $current_player){
                break;
            }
            $HorizontalCounter++; 
        }
        return $HorizontalCounter >= self::WIN ? true : false;
        
    }

     /**
     * Function check Negative Diagonal winning 
     *        [X]
     *     [X]
     *   [X]
     * [X]
     * function run from the point the user choose to type his discs
     * check : first start to search on the upper right side of the selected userMove, then starts to search below left of the userMove selection
     * In case of sequence at least 4 of the current player in a Diagonal - player won
     * @param $userMove - The user selected column
     * @return True in case of a win else False
     */
    public function checkNegativeDiagonalWin($userMove){
        $diagonalCounter = self::ZERO;
        $gameBoards =  $this->board->gameBoard; 
        $current_player = "[$this->currentPlayer]";
        for($row = $this->lastRowInsert-1 ,$col = $userMove; $row > -1 && $col < Board::COLUMNS  ; $row--, $col++ ){
            if($gameBoards[$row][$col] != $current_player){
                break;
            }
            $diagonalCounter++;
        }
        for($row = $this->lastRowInsert ,$col = $userMove-1; $row < Board::ROWS && $col > -1  ; $row++, $col-- ){
            if($gameBoards[$row][$col] != $current_player){
                break;
            }
            $diagonalCounter++;
        }
        return $diagonalCounter >= self::WIN ? true : false;
    }

    /**
     * Function check Positive Diagonal wining 
     * [X]
     *   [X]
     *     [X]
     *       [X]
     * function run from the point the user choose to type his discs
     * check : first start to search on the lower rigt of the userMove selection , then starts to search to upper left side of the userMove
     * In case of sequence at least 4 of the current player in a Diagonal - player won
     * @param $userMove - The user selected column
     * @return True in case of a win else False
     */
    // protected function checkNegativeDiagonalWin($userMove){
    public function checkPositiveDiagonalWin($userMove){
        $positivediagonalCounter = self::ZERO;
        $gameBoards =  $this->board->gameBoard; 
        $current_player = "[$this->currentPlayer]";
        for($row = $this->lastRowInsert+1 ,$col = $userMove; $row < Board::ROWS  && $col < Board::COLUMNS ; $row++, $col++ ){
            if($gameBoards[$row][$col] != $current_player){
                break;
            }
            $positivediagonalCounter++;
        }
        for($row = $this->lastRowInsert ,$col = $userMove-1; $row > -1 && $col > -1  ; $row--, $col-- ){
            if($gameBoards[$row][$col] != "[$this->currentPlayer]"){
                break;
            }
            $positivediagonalCounter++;
        }
        return $positivediagonalCounter >= self::WIN ? true : false;
    }
    
    
    

    /***********************
     *       Player        *
     **********************/

     /**
      * Set current player
      */
    public function setCurrentPlayer($player){
        $this->currentPlayer = $player;
    }

    /**
     * Get current player
     */
    public function getCurrentPlayer(){
        return $this->currentPlayer;
    }

     /**
      * Set Last Row inseat
      */
    public function setLastRowInsert($row){
         $this->lastRowInsert = $row;
    }

    /**
      * Set Last Row inseat
      */
    public function getLastRowInsert(){
        return $this->lastRowInsert;
   }

    /**
     * Function Switch Players 
     */
     public function switchPlayer(){
        $currentPlayer = $this->currentPlayer;
        $this->currentPlayer = $currentPlayer == self::FIRST_PLAYER ? self::SECOND_PLAYER : self::FIRST_PLAYER;
    }

    /**
     * Reset Data 
     */
    protected function resetData(){
        $this->totalMoves = self::ZERO;
        $this->gameOver = false;
        $this->currentPlayer = self::ZERO;
        $this->lastRowInsert = -1;

    }
}