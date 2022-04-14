<?php

use App\Controller\BlogController;
use App\Http\Request;
use App\Http\Response;
use App\Router;


require_once __DIR__."/vendor/autoload.php";


try {

    Router::execute();

    Router::collection("/",function (){

        Router::get("/bar",[BlogController::class,"list"]);

        Router::get("/foo",function (Request $request,Response $response){
            var_dump(Router::execute() === Router::execute());
        });

        Router::get("/foo/bar",[BlogController::class,"all"]);
    });

}catch (Exception | BadMethodCallException $e){
    echo $e->getMessage();
}

