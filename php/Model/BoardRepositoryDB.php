<?php


namespace Aac\Model;


/**
 * OK. I wont be able to finish this.
 * We should use prepared statements as they are more secure.
 * A big decision here would be how to store the data stucture.
 * A simple, but a little hacky solution would be to just store the board as a JSON string
 *
 *
 */
class BoardRepositoryDB implements  BoardRepositoryInterface
{


    /**
     * Stores new board, returns its id
     */
    public function createNewBoard($board)
    {
        // TODO: Implement createNewBoard() method.
    }

    /**
     * saves board to "persistent" storage
     * @param $boardId
     * @param $board
     */
    public function saveBoard($boardId, $board)
    {
        // TODO: Implement saveBoard() method.
    }

    /**
     * return stored board fron storage
     * @param $boardId
     * @return array a BoardData
     */
    public function loadBoard($boardId)
    {
        // TODO: Implement loadBoard() method.
    }
}