<?php

namespace Aac\Model;

interface BoardRepositoryIntefrace {


    /**
     * saves board to "persistent" storage
     * @param $board
     */
    public function saveBoard($board);

    /**
     * return stored board fron storage
     * @param $boardId
     * @return array a BoardData
     */
    public function loadBoard($boardId);
} 