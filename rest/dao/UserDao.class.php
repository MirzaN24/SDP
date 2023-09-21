<?php

require_once "BaseDao.class.php";

class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct("user");
  }
  
  public function get_user_by_username($username){
    return $this->query_unique("SELECT * FROM user WHERE username=:username", ['username' => $username]);
  }

  public function get_user_by_email($email){
    return $this->query_unique("SELECT * FROM user WHERE email = :email", ['email' => $email]);
  }
  
  public function add($entity){
    return parent::add([
      "username" => $entity['username'],
      "password" => md5($entity['password']),
      "email" =>$entity['email']
    ]);
  }

}

?>