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



    }

} 