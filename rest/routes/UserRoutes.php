<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('GET /user', function(){
    Flight::json(Flight::user_service()->get_all());
});

Flight::route('GET /user/@id', function($id){
    Flight::json(Flight::user_service()->get_by_id($id));
});

Flight::route('DELETE /user/@id', function($id){
    Flight::user_service()->delete($id);
    Flight::json(['message' => "User deleted!"]);
});

Flight::route('POST /user', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User added successfuly!',
                  'data' => Flight::user_service()->add($request)]);
});

Flight::route('PUT /user/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User updated successfuly!',
                  'data' => Flight::user_service()->update($request, $id)]);
});

Flight::route('POST /login', function(){
    $login = Flight::request()->data->getData();
    $user_dao = new UserDao();
    $user = $user_dao->get_user_by_username($login['username']);

    if(isset($user['id'])){
        if($user['password'] == md5($login['password'])){
            unset($user['password']);
            $jwt = JWT::encode($user, Config::JWT_SECRET(), 'HS256');
            Flight::json(["token" => $jwt]);
        } else {
            Flight::json(["message" => "Password is incorrect."], 404);
        }
    } else {
        Flight::json(["message" => "User does not exist."], 404);
    }   

});

?>