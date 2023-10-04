<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\Dotenv\Dotenv;

if (!in_array('RENDER', $_ENV)) { //zakomentarisi kada budes pokazivao na renderu
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__.'/.env');
}

require("services/UserService.php");
require("services/TextService.php");

Flight::register('user_service', "UserService");
Flight::register('text_service', "TextService");

require_once "routes/UserRoutes.php";
require_once "routes/TextRoutes.php";

/*Flight::map('error', function(Exception $ex){
    Flight::json(['message' => $ex->getMessage()], 500);
}); */

//middleware method for login and register

Flight::route('/*', function(){
    $path = Flight::request()->url;
    if($path == '/login' || $path == '/register' || $path == '/docs.json') return TRUE; //exclude /login, /docs.json and /register
    $headers = getallheaders();
    if(@!$headers['Authorization']){
        Flight::json(["message" => "Authorization is missing!"], 403);
        return FALSE;
    } else {
        try {
            $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::set('admin', $decoded);
            return TRUE;
        } catch (\Throwable $th) {
            Flight::json(["message" => "Authorization token is not valid!"], 403);
            return FALSE;
        }
    }
});

Flight::start();
?>