<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require '../vendor/autoload.php';

require("services/UserService.php");
require("services/TextService.php");

Flight::register('user_service', "UserService");
Flight::register('text_service', "TextService");


require_once "routes/UserRoutes.php";
require_once "routes/TextRoutes.php";



Flight::start();
?>