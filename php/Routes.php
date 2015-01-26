<?php

namespace Aac;

use Aac\Model\Board;
use Slim\Slim;

class Routes
{


    public static function  load(Slim $app)
    {

        $app->get('/', function () use ($app) {

            $app->render('home.twig',array('hello' => 'world') );

        });


        $app->get('/games/:id', function ($id) use ($app) {


            /** @var $board Board */
            $board = $app->Board;

            $app->render('game.twig', array('game' => $id, 'board' => $board->getData()));
        });

        $app->any('/games/:id/put/:column', function ($id, $column) use ($app) { //any just for debugging - better to be a post

            /** @var $board Board */
            $board = $app->Board;

            if($board->putDisc($id, $column)){
                $result = array(
                    'player' => $id,
                    'column' => $column,
                    'success' => 'yes'
                );

                header("Content-Type: application/json");
                echo json_encode($result);
            }
        });


    }

} 