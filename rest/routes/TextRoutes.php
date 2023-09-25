<?php

Flight::route('GET /text', function(){
    Flight::json(Flight::text_service()->get_all());
});

Flight::route('GET /text/@id', function($id){
    Flight::json(Flight::text_service()->get_by_id($id));
});

Flight::route('DELETE /text/@id', function($id){
    Flight::text_service()->delete($id);
    Flight::json(['message' => "Text deleted!"]);
});

Flight::route('POST /text', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Text added successfuly!',
                  'data' => Flight::text_service()->add($request)]);
});

/*Flight::route('PUT /text/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Text updated successfuly!',
                  'data' => Flight::text_service()->update($request, $id)]);
}); */

Flight::route('POST /save_results/@user_id', function($user_id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Text added successfuly!',
                  'data' => Flight::text_service()->add($request, $user_id)]);
});

Flight::route('POST /analyze', function() {
    $request = Flight::request()->data->getData();
    $text = $request['text'];
    putenv(Config::PYTHON_PATH()); //ovo je na local testiranju
    //putenv("PYTHONPATH=".__DIR__."/../env/lib/python3.9/site-packages");

    //$result = shell_exec(__DIR__.'/../env/bin/python ../model/script.py "'. $text . '"');
    $result = shell_exec(Config::ANALYSE_COMMAND() . ' ../model/script.py "'. $text . '"'); //ovo je na local testiranju
    $result = trim($result);
    Flight::json([ 'message' => $result ]);
});

Flight::route('GET /user_results/@user_id', function($user_id){
    Flight::json(Flight::text_service()->get_results_by_user_id($user_id)); 
})
?>