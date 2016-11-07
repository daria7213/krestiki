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
        $this->updateStatus();
        $this->gameState->changeTurn();
    }

    /**
     *  Ход компьютера
     */
    public function aiMove(){
        $this->aiPlayer->makeMove($this->gameState);

        $this->updateStatus();
        $this->gameState->changeTurn();
    }

    /**
     * Возвращает массив полей
     *
     * @return array
     */
    public function getState(){
        return $this->gameState->getBoard();
    }

    /**
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     *  Изменяет результат игры, если есть выигрыш или ничья
     */
    public function updateStatus(){

        if($this->gameState->isOver()){
            $this->winner = $this->gameState->getTurn();
        } elseif(!$this->gameState->getEmptyFields()){
            $this->winner = "draw";
        }
    }
}