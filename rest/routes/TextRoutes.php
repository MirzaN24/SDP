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

Flight::route('PUT /text/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Text updated successfuly!',
                  'data' => Flight::text_service()->update($request, $id)]);
});

?>