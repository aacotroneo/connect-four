<?php


namespace Aac\Model;


class Board
{

    const ROWS = 6;
    const COLS = 7;


    protected $boardData;

    function __construct($repo, $id = null)
    {
        if (null === $id) {
            $this->initialize();
        } else {
            $this->boardData = $repo->loadBoard($id);
        }
    }

    /**
     * Right now returns an array. With
     *    0: emtpy
     *    1: player one
     *    2: player two
     * @return array
     */
    function getData()
    {

        return $this->boardData;
    }


    protected function initialize()
    {
        $board = array();
        for ($i = 0; $i < self::ROWS; $i++) {
            $row = array_fill(0, self::COLS, 0);
            $board[] = $row;
        }
        $this->boardData = $board;

    }


} 