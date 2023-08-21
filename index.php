<?php
require 'vendor/autoload.php';

Flight::route('/', function(){
    echo "Hello from my first SDP route :)";
});

Flight::start();
?>