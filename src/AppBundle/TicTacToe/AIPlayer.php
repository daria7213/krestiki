<?php

namespace AppBundle\TicTacToe;

class AIPlayer
{
    /**
     * @param GameState $state
     */
    public function makeMove($state){

        $board = $state->getBoard();
        $moveIndex = $this->findBestMove($board);

        //если блокировать нечего, выбирает случайное пустое поле
        if($moveIndex === null){
            $emptyFields = $state->getEmptyFields();
            $moveIndex = $emptyFields[array_rand($emptyFields,1)];
        }

        $board[$moveIndex] = 'o';
        $state->setBoard($board);
    }

    /**
     * Возвращает индекс поля, блокируещего 2 в ряд
     * @param $board
     * @return mixed|null
     */
    public function findBestMove($board){

        $values = [];

        //ряды
        for($i = 0; $i < 9; $i += 3){
            $values[] = [$i => $board[$i], $i+1 => $board[$i+1], $i+2 => $board[$i+2]];
        }

        //столбцы
        for($i = 0; $i < 3; $i++){
            $values[] = [$i => $board[$i], $i+3 => $board[$i+3], $i+6 => $board[$i+6]];
        }

        //диагонали
        $values[] = [0 => $board[0], 4 => $board[4], 8 => $board[8]];
        $values[] = [2 => $board[2], 4 => $board[4], 6 => $board[6]];

        //проверка на наличие 2 "х" в каждой строке
        foreach($values as $value){
            $count = array_count_values($value);
            if(isset($count["x"]) && $count["x"] == 2){
                $index = array_search("e", $value);
                if($index !== false) return $index;
            }
        }

        return null;
    }
}