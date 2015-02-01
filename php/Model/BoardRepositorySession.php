<?php


namespace Aac\Model;


/**
 * Created by IntelliJ IDEA.
 * User: Alejandro
 * Date: 26/01/2015
 * Time: 07:02 PM
 */
class BoardRepositorySession implements  BoardRepositoryInterface
{


    function __construct()
    {
//        session_start();
    }


    public function saveBoard($id, $board)
    {

        $_SESSION['current_board'][$id] = $board;

    }

    public function createNewBoard($board)
    {

        $id = uniqid(); //db autoincrement
        $this->saveBoard($id, $board);
        return $id;
    }

    public function loadBoard($id)
    {

        if (isset($_SESSION['current_board']) && isset($_SESSION['current_board'][$id])) {
            return $_SESSION['current_board'][$id];
        } else {
            return null;
        }

    }
} 