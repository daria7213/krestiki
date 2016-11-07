<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    /**
     * @Route("/", options={"expose"=true}, name="start")
     */
    public function indexAction(Request $request)
    {
        return $this->render('game/start.html.twig');
    }

    /**
     * @Route("/play", options={"expose"=true}, name="play")
     */
    public function gameAction(Request $request){

        $game = $this->get("tictactoe");

        //обработка ajax запроса
        if($request->isXmlHttpRequest()){
            $game->playerMove($request->request->get("board"));
            if($game->getWinner() == "none"){
                $game->aiMove();
                if($game->getWinner() == "none"){
                    //возвращает текущее состояние поля, если игра продолжается
                    return new JsonResponse(["board" => $game->getState()]);
                }
            }

            //возвращает победителя игры и конечное состояние поля
            return new JsonResponse(["winner" => $game->getWinner(), "board" => $game->getState()]);
        }

        return $this->render('game/play.html.twig', ["board" => $game->getState()]);
    }

    /**
     *
     * @Route("/over/{winner}", options={"expose"=true}, name="over")
     */
    public function overAction($winner){
        return $this->render('game/over.html.twig', ["winner" => $winner]);
    }
}
