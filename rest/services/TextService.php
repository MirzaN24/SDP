<?php

require_once 'BaseService.php';
require_once __DIR__."/../dao/TextDao.class.php";


class TextService extends BaseService{

    public function __construct(){
        parent::__construct(new TextDao);
    }
    
}

?>