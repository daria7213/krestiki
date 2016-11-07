<?php

namespace AppBundle\TicTacToe;


class GameState
{
    /**
     * Массив игровых клеток
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

        $values = [];

        //ряды
        for($i = 0; $i < 9; $i += 3){
            $values[] = [$this->board[$i],$this->board[$i+1],$this->board[$i+2]];
        }

        //столбцы
        for($i = 0; $i < 3; $i++){
            $values[] = [$this->board[$i],$this->board[$i+3],$this->board[$i+6]];
        }

        //диагонали
        $values[] = [$this->board[0], $this->board[4], $this->board[8]];
        $values[] = [$this->board[2], $this->board[4], $this->board[6]];

        //проверка наличия заполненных строк
        foreach($values as $value){
            if( array_unique($value) === [$this->turn]){
                return true;
            }
        }

        return false;
    }

    /**
     * Возвращяет индексы пустых клеток
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