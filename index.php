<?php

use App\Controller\BlogController;
use App\Router;


require_once __DIR__."/vendor/autoload.php";


try {

    $router = new Router();

    $router->get("/blog",[BlogController::class,"list"]);


    $router->get("/blog/update",[BlogController::class,"update"]);

    $router->post("/blog/create",[BlogController::class,'create']);


    $router->group("/zanko",function () use ($router){

        $router->get("/name",[BlogController::class,"list"]);

        $router->get("/last_name",[BlogController::class,"lastName"]);

    });

    $router->delete("/t",[BlogController::class,"list"]);


}catch ( BadMethodCallException $e){
    echo "<br>";
    echo "<b>{$e}</b>";
}

