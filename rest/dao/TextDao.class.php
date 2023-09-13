<?php

require_once "BaseDao.class.php";

class TextDao extends BaseDao{

  public function __construct(){
    parent::__construct("text");
  }
  
}

?>