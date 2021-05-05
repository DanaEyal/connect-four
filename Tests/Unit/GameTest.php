<?php declare(strict_types=1);

require './vendor/autoload.php';
require 'app/Game.php';
require_once 'app/Messages.php';

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase {

  protected $game;  

  public function setUp() : void{
    $this->game = new Game();
  }

  /** @test */
  public function check_instance_of_game_class(){
    $this->assertInstanceOf("Game",$this->game);
  }

  /** @test */
  public function get_set_current_player(){
    $this->game->setCurrentPlayer(1);
    $this->assertEquals($this->game->getCurrentPlayer(), 1);
  }

  /** @test */
  public function get_set_last_row_insert(){
    $this->game->setLastRowInsert(1);
    $this->assertEquals($this->game->getLastRowInsert(), 1);
  }

   /** @test */
  public function switch_player(){
    $this->game->setCurrentPlayer(1);
    $this->game->switchPlayer();
    $this->assertEquals($this->game->getCurrentPlayer(), 2);
  }

   /** @test */
  public function check_valid_move(){

      $this->assertTrue($this->game->checkValidMove(2));
      $this->assertTrue($this->game->checkValidMove(7));
      $this->assertFalse($this->game->checkValidMove(0));
      $this->assertFalse($this->game->checkValidMove(-1));
      $this->assertFalse($this->game->checkValidMove(66));
      $this->assertFalse($this->game->checkValidMove('g'));
      $this->assertFalse($this->game->checkValidMove('$'));
  }

   /** @test */
   public function validate_is_full_column() {
    /**Case 1 that column number 1 is full */
      $board = new Board();
      $this->game->setCurrentPlayer(1);

      
      $game_board= 
      [
        ["[ ]", "[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[1]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[1]", "[1]", "[ ]", "[ ]", "[2]", "[ ]"],
        ["[2]", "[1]", "[1]", "[2]", "[ ]", "[1]", "[2]"]
      ];
      //set board with table
      $board->setBoard($game_board); 

      //validate if it reviles that column is full by match printed message
      $this->assertFalse($this->game->validateIsFullColumn(2));
    
  }

   /** @test */
  public function validate_is_not_full_column() {
  /** Case 2 that column number 2 is NOT full */
      $board = new Board();
      $this->game->setCurrentPlayer(1);
      
      $game_board= 
      [
        ["[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[1]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[1]", "[1]", "[ ]", "[ ]", "[2]", "[ ]"],
        ["[2]", "[1]", "[1]", "[2]", "[ ]", "[1]", "[2]"]
      ];

      //set board with table
      $board->setBoard($game_board); 

       //validate if it reviles that column is full by match printed message
      $this->assertEquals($this->game->validateIsFullColumn(2),0);
  }

  /** @test */
  public function validate_is_full_board(){

      $this->game->setCurrentPlayer(1);

      $game_board =
      [
        ["[1]", "[2]", "[1]", "[2]", "[1]", "[2]", "[1]"],
        ["[2]", "[1]", "[2]", "[2]", "[2]", "[1]", "[2]"],
        ["[1]", "[2]", "[1]", "[2]", "[1]", "[2]", "[1]"],
        ["[1]", "[2]", "[1]", "[2]", "[1]", "[2]", "[1]"],
        ["[2]", "[1]", "[2]", "[1]", "[2]", "[1]", "[2]"],
        ["[1]", "[1]", "[2]", "[1]", "[1]", "[1]", "[2]"]
      ];
      //set board with table
      $this->game->board->setBoard($game_board); 

      //validate full board 
      $this->assertEquals($this->game->validateIsFullBoard(),1);

  }

  /** @test */
  public function check_vertical_win(){

    $this->game->setCurrentPlayer(1);
    $this->game->setLastRowInsert(5);

    $game_board =
    [
      ["[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
      ["[ ]", "[ ]", "[ ]", "[ ]", "[2]", "[ ]", "[2]"],
      ["[1]", "[1]", "[ ]", "[ ]", "[1]", "[ ]", "[1]"],
      ["[1]", "[1]", "[ ]", "[2]", "[1]", "[2]", "[1]"],
      ["[2]", "[1]", "[ ]", "[1]", "[2]", "[1]", "[2]"],
      ["[1]", "[1]", "[2]", "[1]", "[1]", "[1]", "[2]"]
    ];
    //set board with table
    $this->game->board->setBoard($game_board); 

    $this->assertEquals($this->game->checkVerticalWin(2),1);

  }
    /** @test */
  public function check_orizontal_win1(){

    $this->game->setCurrentPlayer(1);
    $this->game->setLastRowInsert(5);


    $game_board =
      [
        ["[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[ ]", "[ ]", "[ ]", "[2]", "[ ]", "[2]"],
        ["[1]", "[ ]", "[ ]", "[ ]", "[1]", "[ ]", "[1]"],
        ["[1]", "[2]", "[ ]", "[2]", "[1]", "[2]", "[1]"],
        ["[2]", "[1]", "[ ]", "[1]", "[2]", "[1]", "[2]"],
        ["[1]", "[1]", "[1]", "[1]", "[1]", "[1]", "[2]"]
      ];

    //set board with table
    $this->game->board->setBoard($game_board);  

    $this->assertEquals($this->game->checkHorizontalWin(3),1);

  }

  /** @test */
  public function check_orizontal_win2(){

    $this->game->setCurrentPlayer(2);
    $this->game->setLastRowInsert(0);


    $game_board =
      [
        ["[ ]", "[ ]", "[ ]", "[2]", "[2]", "[2]", "[2]"],
        ["[2]", "[1]", "[ ]", "[1]", "[2]", "[1]", "[2]"],
        ["[1]", "[1]", "[ ]", "[1]", "[1]", "[2]", "[1]"],
        ["[2]", "[2]", "[ ]", "[2]", "[1]", "[2]", "[1]"],
        ["[2]", "[1]", "[ ]", "[1]", "[2]", "[1]", "[2]"],
        ["[1]", "[1]", "[ ]", "[2]", "[1]", "[1]", "[2]"]
      ];

      //set board with table
    $this->game->board->setBoard($game_board);

    $this->assertEquals($this->game->checkHorizontalWin(6),1);
  }


  /** @test */
  public function check_negative_diagonal_win(){

    $this->game->setCurrentPlayer(1);
    $this->game->setLastRowInsert(0);

    $game_board =
      [
        ["[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[1]"],
        ["[ ]", "[ ]", "[ ]", "[2]", "[ ]", "[1]", "[1]"],
        ["[ ]", "[ ]", "[ ]", "[1]", "[1]", "[2]", "[2]"],
        ["[ ]", "[2]", "[ ]", "[1]", "[2]", "[2]", "[1]"],
        ["[ ]", "[1]", "[ ]", "[1]", "[1]", "[1]", "[2]"],
        ["[1]", "[1]", "[ ]", "[2]", "[1]", "[1]", "[1]"]
      ];

      //set board with table
    $this->game->board->setBoard($game_board);  

    //validate full board 
    $this->assertEquals($this->game->checkNegativeDiagonalWin(7),1);
  }


  /** @test */
  public function check_positive_diagonal_win(){

    // $board = new Board();
    $this->game->setCurrentPlayer(2);
    $this->game->setLastRowInsert(2);

    $game_board =
      [
        ["[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[2]", "[2]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[1]", "[1]", "[2]", "[ ]", "[1]", "[ ]", "[ ]"],
        ["[2]", "[1]", "[1]", "[2]", "[2]", "[ ]", "[ ]"],
        ["[1]", "[1]", "[2]", "[2]", "[1]", "[ ]", "[ ]"],
        ["[1]", "[2]", "[1]", "[2]", "[1]", "[1]", "[1]"]
      ];

      //set board with table
    $this->game->board->setBoard($game_board);  

    //validate full board 
    $this->assertEquals($this->game->checkPositiveDiagonalWin(3),1);
  }

  /** @test */
  public function check_positive_diagonal_win2(){

    // $board = new Board();
    $this->game->setCurrentPlayer(1);
    $this->game->setLastRowInsert(5);

    $game_board =
      [
        ["[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]", "[ ]"],
        ["[ ]", "[ ]", "[1]", "[ ]", "[1]", "[ ]", "[ ]"],
        ["[ ]", "[ ]", "[1]", "[1]", "[2]", "[ ]", "[ ]"],
        ["[ ]", "[1]", "[2]", "[2]", "[1]", "[ ]", "[ ]"],
        ["[ ]", "[2]", "[1]", "[2]", "[1]", "[1]", "[1]"]
      ];

      //set board with table
    $this->game->board->setBoard($game_board);  

    //validate full board 
    $this->assertEquals($this->game->checkPositiveDiagonalWin(6),1);
  }


}

