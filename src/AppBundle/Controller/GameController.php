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
        // replace this example code with whatever you need
        return $this->render('game/start.html.twig');

    }

    /**
     * @Route("/play", options={"expose"=true}, name="play")
     */
    public function gameAction(Request $request){

        $game = $this->get("tictactoe");

        if($request->isXmlHttpRequest()){
            $game->playerMove($request->request->get("board"));
            if($game->getStatus() == "running"){
                $game->aiMove();
                if($game->getStatus() == "running"){
                    return new JsonResponse(["board" => $game->getState()]);
                }
            }

            return new JsonResponse(["winner" => $game->getStatus(), "board" => $game->getState()]);
        }

        return $this->render('game/play.html.twig', ["board" => $game->getState()]);
    }

    /**
     *
     * @Route("/over/{winner}", options={"expose"=true}, name="over")
     */
    public function overAction($winner){
        $game = $this->get("tictactoe");
        $game->playerMove(['x','e','e','e','e','e','e','e','e']);
        return $this->render('game/over.html.twig', ["winner" => $winner]);
    }
}
