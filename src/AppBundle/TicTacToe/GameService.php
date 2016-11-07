<?php
namespace AppBundle\TicTacToe;

class GameService
{
    /**
     * Текущее состояние игры
     *
     * @var GameState
     */
    private $gameState;

    /**
     * Игрок-компьютер
     *
     * @var AIPlayer
     */
    private $aiPlayer;

    /**
     * Текущий результат игры
     *
     * @var string
     */
    private $winner;

    public function __construct() {
        $this->aiPlayer = new AIPlayer();
        $this->gameState = new GameState();
        $this->winner = "none";
    }

    /**
     * Ход игрока
     *
     * @param $board
     */
    public function playerMove($board){
        $this->gameState->setBoard($board);
        $this->updateWinner();
        $this->gameState->changeTurn();
    }

    /**
     *  Ход компьютера
     */
    public function aiMove(){
        $this->aiPlayer->makeMove($this->gameState);
        $this->updateWinner();
        $this->gameState->changeTurn();
    }

    /**
     * Возвращает массив клеток
     *
     * @return array
     */
    public function getState(){
        return $this->gameState->getBoard();
    }

    /**
     * Возвращает результат игры
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     *  Изменяет результат игры, если есть выигрыш или ничья
     */
    public function updateWinner(){

        if($this->gameState->isOver()){
            $this->winner = $this->gameState->getTurn();
        } elseif(!$this->gameState->getEmptyFields()){
            $this->winner = "draw";
        }
    }
}