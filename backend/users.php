<?php
$mysqli = new mysqli("localhost", "root", "", "echm_trainer_db");
$users = $mysqli->query("SELECT * FROM `users`");
$users_list = json_encode(fetch_list($users));

echo $users_list;

function fetch_list($sql_request) {
    $list = [];
    while ($row = $sql_request->fetch_assoc()) {
        array_push($list, $row);
    }
    return $list;
}