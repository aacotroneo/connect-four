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

    /**
     * Puts a disc from player in specified column
     * @param $playerId
     * @param $column
     * @return bool return true if successfull false otherwise
     */
    function putDisc($playerId, $column){

        //do stuff
        return true;
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