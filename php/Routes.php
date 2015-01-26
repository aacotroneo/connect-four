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

            $disc_added = $board->putDisc($id, $column);
            if(!isset($disc_added['error'])){
                $result = array(
                    'player' => $disc_added['player'],
                    'column' => $disc_added['column'],
                    'row' => $disc_added['row'],
                    'success' => 'yes'
                );


            }else {
                $result = array(
                    'sucess' => 'no',
                    'error' => $disc_added['error'],
                );
            }
            header("Content-Type: application/json");
            echo json_encode($result);

        });


        $app->any('/games/:id/board', function ($id) use ($app) { //any just for debugging - better to be a post
            //the board should be the same for both players for now, but it may be possible to change

            /** @var $board Board */
            $board = $app->Board;

            $boardData = $board->getData();

            $result = array(
                'board' => $boardData,
                'success' => 'yes'
            );
            header("Content-Type: application/json");
            echo json_encode($result);


        });

    }

} 