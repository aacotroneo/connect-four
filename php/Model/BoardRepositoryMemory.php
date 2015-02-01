<?php

namespace Aac\Model;


class BoardRepositoryMemory implements  BoardRepositoryInterface

{

    protected $boards;

    function __construct()
    {
    }


    public function saveBoard($id, $board)
    {
        $this->boards[$id]= $board;
    }

    public function createNewBoard($board)
    {

        $id = uniqid(); //db autoincrement
        $this->saveBoard($id, $board);
        return $id;
    }

    public function loadBoard($id)
    {
        if(isset($this->boards[$id])){
            return $this->boards[$id];
        }else {
            return null;
        }

    }
} 