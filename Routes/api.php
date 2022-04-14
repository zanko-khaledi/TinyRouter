<?php


use App\Router;

Router::execute();

Router::get("/",function (\App\Http\Request $request,\App\Http\Response $response){
    echo $response->json("Hello World");
});

Router::get("/foo",[\App\Controller\BlogController::class,"list"]);

