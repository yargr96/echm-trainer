<?php
require_once('./classes/users.php');
require_once('./classes/parameters.php');

$queries = [
  'get_users' => 'get_users',
  'add_user' => 'add_user',
  'delete_user' => 'delete_user',
  'change_password' => 'change_password',
  'get_input_parameters' => 'get_input_parameters',
];

$query = json_decode($_POST['query']);
$query_type = $query->query_type;
$query_payload = $query->payload;

if (isset($queries[$query_type])) {
  $queries[$query_type]($query_payload);
} else {
  echo "Нет такого метода: " . $query_type;
}

function get_users()
{
  $users = new Users();
  echo json_encode($users->get());
}

function add_user($data)
{
  $users = new Users();
  $result = $users->add_user($data);
  echo $result;
}

function delete_user($data)
{
  $users = new Users();
  var_dump($users->delete_user($data->name));
}

function change_password($data)
{
  $user_name = $data->name;
  $password = $data->password;

  $users = new Users();
  $response = $users->change_password($user_name, $password);
  
  var_dump($response);
}

function get_input_parameters() {
  $parameters = new Parameters();
  echo json_encode($parameters->get_input_parameters());
}