<?php

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

Flight::route('POST /analyze', function() {
    $request = Flight::request()->data->getData();
    $text = $request['text'];
    putenv("PYTHONPATH=C:\Bitnami\wampstack-8.1.2-0\apache2\htdocs\SDP\env\Lib\site-packages");
    //putenv("PYTHONPATH=".__DIR__."/env/lib/python3.10/site-packages");

    $result = shell_exec('C:\Bitnami\wampstack-8.1.2-0\apache2\htdocs\SDP\env\Scripts\python.exe ../model/script.py "'. $text . '"');
    //$result = exec(__DIR__.'/env/bin/python model/script.py "'. $text . '"');
    $result = trim($result);
    Flight::json([ 'message' => $result ]);
});

?>