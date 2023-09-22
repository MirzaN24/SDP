<?php

require_once "BaseDao.class.php";

class TextDao extends BaseDao{

  public function __construct(){
    parent::__construct("text");
  }

  public function get_results_by_user_id($user_id){
    $query = "SELECT user.username, text.content, text.result 
              FROM user 
              JOIN text ON text.user_id = user.id
              WHERE text.user_id = :id";
    return $this->query($query, ['id' => $user_id]);
  }
  
}

?>