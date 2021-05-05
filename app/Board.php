<?php


class Board{

    const ROWS = 6;
    const COLUMNS  = 7;
    const CELL = "[ ]";

    public $gameBoard = array();
    protected $maxMoves = 0;

    public function __construct(){
       $this->_init();
    }
   
    /**
     * function initializes the board arrayand print the board in console
     */
    public function _init(){
        
        $this->boardArray();
        $this->setMaxMoves();
    }  
     
    /**
     * function create the board array when each empty cell looks -> "[ ]"
     */
    protected function boardArray(){
        $cells = [];
        
        for ($row = 0; $row < self::COLUMNS; $row++) {
            for ($col = 0; $col < self::ROWS; $col++) {
                $cells[$col][$row] = self::CELL;
            }
        }
        $this->setBoard($cells);
    }

    /**
     * Function will Print The board to console
     */
    public function printBoard(){
       
        echo "\n";
        $data = $this->getBoard();
        $data[2][] = 2;
        for ($i = 0; $i < self::ROWS; $i++) {
            for ($j = 0; $j < self::COLUMNS; $j++) {
                echo $data[$i][$j] . " ";
            }
            echo "\n";
        }
        echo $this->boardLabels() ."\n";
    }

    /**
     * Function Set Bord Labels (Numbers below the Board)
     * acording to Columns
     */
    protected function boardLabels(){
        $boardLabel = " ";
        for($col = 0; $col < self::COLUMNS; $col++ ){
            $boardLabel .= ($col + 1) . "   ";
        }
        $boardLabel .= "\n";
        return $boardLabel;
    }

    /**
     * Function set the board 
     */
    public function setBoard($cells){
        $this->gameBoard = $cells;
    }

    /**
     * Function get the board
     */
    public function getBoard(){
        return $this->gameBoard;
    }

    /**
     * Set Max moves in a game 
     * When reached the max moves game is over
     */
    public function setMaxMoves(){
        $cols = $this->getColumns();
        $rows = $this->getRows();
        $this->maxMoves = $cols * $rows;
    }

    /**
     * function return max move of the game board
     */
    public function getMaxMoves(){
        return $this->maxMoves;
    }


    /**
     * Function get Board Rows
     */
    public function getRows(){
        return self::ROWS;
    }

    /**
     * function get Board Columns
     */
    public function getColumns(){
        return self::COLUMNS;
    }
    
}