<?php

namespace AppBundle\TicTacToe;


class GameState
{
    /**
     * Массив игровых полей
     *
     * @var array
     */
    private $board;

    /**
     * Текущий ход X или O
     *
     * @var string
     */
    private $turn;

    public function __construct($board = ['e','e','e','e','e','e','e','e','e'])
    {
        $this->board = $board;
        $this->turn = 'x';
    }

    /**
     * Проверяет выиграл ли текущий игрок
     *
     * @return bool
     */
    public function isOver(){

        //проверить ряды
        for($i = 0; $i < 9; $i += 3){
            $values = [$this->board[$i],$this->board[$i+1],$this->board[$i+2]];
            if( array_unique($values) === [$this->turn]){
                return true;
            }
        }

        //проверить столбцы

        for($i = 0; $i < 3; $i++){
            $values = [$this->board[$i],$this->board[$i+3],$this->board[$i+6]];
            if( array_unique($values) === [$this->turn]){
                return true;
            }
        }
        //проверить диагонали
        if($this->board[0] == $this->turn && $this->board[0] == $this->board[4] && $this->board[4] == $this->board[8]){
            return true;
        }

        if($this->board[2] == $this->turn && $this->board[2] == $this->board[4] && $this->board[4] == $this->board[6]){
            return true;
        }

        return false;
    }

    /**
     * Возвращяет индексы пустых полей
     *
     * @return array
     */
    public function getEmptyFields(){
        $empty = [];
        foreach($this->board as $k=>$v){
            if($v == 'e'){
                $empty[] = $k;
            }
        }
        return $empty;
    }

    /**
     *  Меняет текущего игрока
     */
    public function changeTurn(){
        if($this->turn == 'x'){
            $this->turn = 'o';
        } else {
            $this->turn = 'x';
        }
    }

    /**
     * @return string
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param array $board
     */
    public function setBoard($board)
    {
        $this->board = $board;
    }
}