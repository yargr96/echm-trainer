<?php
class DB {
    function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'echm_trainer_db');
    }

    private $connection;
    public function query($query) {
        return $this->connection->query($query);
    }

    public function fetch_assoc_list($query) {
        $response = $this->query($query);
        $list = [];

        while($row = $response->fetch_assoc()) {
            array_push($list, $row);
        }

        return $list;
    }
}