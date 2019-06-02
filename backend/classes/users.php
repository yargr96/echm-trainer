<?php
require_once('db.php');

class Users
{
  function __construct()
  {
    $this->db = new DB();
  }
  
  public function get()
  {
    $query_string = 'SELECT * FROM `users`';
    $users_list = $this->db->fetch_assoc_list($query_string);
    return $users_list;
  }

  public function add_user($data) {
    $user_name = $data->name;
    $is_admin = (int)$data->isAdmin;
    $password_hash = password_hash($data->password, PASSWORD_DEFAULT);

    // Проверка на наличие пользователя в базе
    if ($this->db->query("SELECT * FROM `users` WHERE `user_name` = '$user_name'")->num_rows) {
      return 0;
    }
    
    $query_string = "INSERT INTO `users` VALUES ('$user_name', '$password_hash', '$is_admin')";
    $this->db->query($query_string);

    return 1;
  }

  public function delete_user($name) {
    $query_string = "DELETE FROM `users` WHERE `user_name` = '$name'";
    return $this->db->query($query_string);
  }

  public function change_password($name, $password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query_string = "UPDATE `users` SET `password_hash` = '$password_hash' WHERE `user_name` = '$name'";
    return $this->db->query($query_string);
  }
}
