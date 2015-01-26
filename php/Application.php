<?php
namespace Aac;

use Aac\Model\Board;
use Aac\Model\BoardRepositorySession;
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


        //I wont make a sophisticated bootstrap
        //just move this code  where it's easy to find
        Routes::load($app);


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


        $app->container->singleton('BoardRepository', function ($c) {

            //lets just start with something! Players can play on the same computer at least!
            return new BoardRepositorySession();
        });

        $app->container->singleton('Board', function ($c) {

            $repository = $c['BoardRepository'];

            $board = new Board($repository);
            return $board;
        });

    }


}