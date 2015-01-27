<?php

namespace Aac\Model;

interface BoardRepositoryIntefrace {


    /**
     * Stores new board, returns its id
     */
    public function createNewBoard($board);

    /**
     * saves board to "persistent" storage
     * @param $boardId
     * @param $board
     */
    public function saveBoard($boardId, $board);

    /**
     * return stored board fron storage
     * @param $boardId
     * @return array a BoardData
     */
    public function loadBoard($boardId);
} 