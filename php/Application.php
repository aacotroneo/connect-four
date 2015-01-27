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

        session_start(); //this should not be here

        /** @var $view Twig */
        $view = $app->view();
        $view->parserExtensions = array(new \Slim\Views\TwigExtension());

        /** @var $twig \Twig_Environment */
        $twig = $view->getEnvironment();
        $twig->addGlobal('base_url', $_SERVER['CONTEXT_PREFIX']);





        $app->container->singleton('BoardRepository', function ($c) {

            //lets just start with something! Players can play on the same computer at least!
            return new BoardRepositorySession();
        });

        $app->container->singleton('Board', function ($c) {

            $repository = $c['BoardRepository'];

            //this should be attached to the users somehow
            $current_game = isset($_SESSION['current_game'])? $_SESSION['current_game'] : null;



            $board = new Board($repository, $current_game);
            if($current_game == null){
                $_SESSION['current_game'] = $board->getGameId(); //save new game
            }


            $c['view']->getEnvironment()->addGlobal('current_game_id', $current_game);

            return $board;
        });

    }


}