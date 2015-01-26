<?php
namespace Aac;

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class Application
{

    protected $app;

    function __construct($config)
    {

        $app = new Slim($config);

        $this->configureApp($app);

        $app->get('/games/:id', function ($id) use ($app) {

            $app->render('game.twig', array('game' => $id));
        });

        $this->app = $app;
    }

    function run()
    {
        $this->app->run();
    }


    protected function configureApp(Slim $app)
    {

        /** @var $view Twig */
        $view = $app->view();
        $view->parserExtensions = array(new \Slim\Views\TwigExtension());

    }


}