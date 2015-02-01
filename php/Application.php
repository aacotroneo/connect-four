<?php
namespace Aac;

use Aac\Model\Board;
use Aac\Model\BoardRepositoryMemory;


use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class Application
{

    protected $app;


    function __construct($config)
    {

        $app = new Slim($config);

        /** @var $view Twig */
        $view = $app->view();
        $view->parserExtensions = array(new \Slim\Views\TwigExtension());

        /** @var $twig \Twig_Environment */
        $twig = $view->getEnvironment();
        $twig->addGlobal('base_url', isset($_SERVER['CONTEXT_PREFIX']) ? $_SERVER['CONTEXT_PREFIX'] : '');


        $app->get('/', function () use ($app) {

            print_r($_SERVER);
            $app->render('home.twig');

        });



        $app->get('/games/:id', function ($id) use ($app) {

            $empty_board = new Board(new BoardRepositoryMemory());

            $app->render('game.twig', array('game' => $id, 'board' => $empty_board->getBoardData()));
        });


        $this->app = $app;
    }

    public function  run()
    {
        $this->app->run();
    }


}