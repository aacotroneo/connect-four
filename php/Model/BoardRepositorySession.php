<?php


namespace Aac\Model;


/**
 * Created by IntelliJ IDEA.
 * User: Alejandro
 * Date: 26/01/2015
 * Time: 07:02 PM
 */
class BoardRepositorySession
    //implements  BoardRepositoryIntefrace
   ///GRR!! http://stackoverflow.com/questions/3704841/php-interface-problem-class-not-found    ??
{


    function __construct()
    {
        session_start();
    }


    public function saveBoard($board)
    {

        $_SESSION['current_board'] = $board;

    }

    public function loadBoard($board)
    {

        if (isset($_SESSION['current_board'])) {
            return $_SESSION['current_board'];
        } else {
            return null;
        }

    }
} 