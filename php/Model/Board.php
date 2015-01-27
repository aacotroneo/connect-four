<?php


namespace Aac\Model;


class Board
{

    const ROWS = 6;
    const COLS = 7;


    protected $boardData;

    protected $boardId;

    /**
     * @var BoardRepositoryIntefrace
     */
    protected $repository;

    function __construct($repo, $id = null)
    {

        $this->repository = $repo;
        $this->boardId = $id;

        if (null === $id) {
            $this->createNewBoard(); //create new Board
        } else {
            $this->load();
        }


    }

    /**
     * Right now returns an array. With
     *    0: emtpy
     *    1: player one
     *    2: player two
     * @return array
     */
    function getBoardData()
    {

        return $this->boardData['board'];
    }

    function getGameId()
    {
        return $this->boardId;
    }

    /**
     * Puts a disc from player in specified column
     * @param $playerId
     * @param $column
     * @return array  if successfull returns array(
     * 'player' => player who made the move,
     * 'column' => column where new disc is placed,
     * 'row' => row where new disc is placed,
     * )
     *          Otherwise returns array ( 'error' => description )
     */
    function putDisc($playerId, $column)
    {

        $curernt_player = $this->getCurrentTurnPlayer();
        if ($curernt_player != $playerId) {
            return array('error' => "Not players turn");
        }
        if ($column < 0 || $column > self::COLS) {
            return array('error' => "Invalid column");
        }

        $next_row = $this->getNextRow($column);
        if ($next_row === null) {
            return array('error' => "It's not your turn player. Its the turn for " . $curernt_player);
        }

        $this->boardData['turn'] = $playerId == 1 ? 2 : 1;
        $this->boardData['board'][$next_row][$column] = $playerId;

        $this->save();

        return array(
            'player' => $curernt_player,
            'column' => $column,
            'row' => $next_row
        );


    }


    protected function createNewBoard()
    {
        $board = array();
        for ($i = 0; $i < self::ROWS; $i++) {
            $row = array_fill(0, self::COLS, 0);
            $board[] = $row;
        }
        $this->boardData['board'] = $board;
        $this->boardData['turn'] = 1; //player one always starts!

        $new_id = $this->repository->createNewBoard($this->boardData);
        $this->boardId = $new_id;
    }

    /**
     * Saves itself
     */
    protected function save()
    {
          $this->repository->saveBoard($this->boardId, $this->boardData);
    }

    /**
     * Loads itself
     */
    protected function load()
    {
        $board = $this->repository->loadBoard($this->boardId);
        $this->boardData = $board;
    }

    /**
     * @return int players id turn.
     */
    protected function getCurrentTurnPlayer()
    {
        return $this->boardData['turn'];
    }

    /**
     * returns where the discs falls, or null if column is full
     */
    protected function getNextRow($column)
    {
        $row = 0;
        while ($row < self::ROWS) {
            if ($this->getValueAt($column, $row) === 0) {
                return $row;
            }
            $row++;
        }

        return null;
    }

    /**
     * Gets value at the board. Warning it does no checks
     */
    protected function getValueAt($column, $row)
    {
        $board = $this->getBoardData();

        return $board[$row][$column];
    }


}