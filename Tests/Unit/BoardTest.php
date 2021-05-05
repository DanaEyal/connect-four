<?php declare(strict_types=1);

require './vendor/autoload.php';
require 'app/Board.php';

use PHPUnit\Framework\TestCase;

final class BoardTest extends TestCase {

    protected $board;  

    public function setUp() : void{
        $this->board = new Board();
    }

    /** @test */
    public function check_instance_of_board_class(){
        $this->assertInstanceOf("Board",$this->board);
    }
     /** @test */
     public function get_rows(){
        $this->assertEquals($this->board->getRows(), 6);
    }
     /** @test */
     public function get_columns(){
        $this->assertEquals($this->board->getColumns(), 7);
    }
    /** @test */
    public function get_max_moves(){
        $this->assertEquals($this->board->getMaxMoves(), 42);
    }
}
