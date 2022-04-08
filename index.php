<?php

use App\Controller\BlogController;
use App\Router;


require_once __DIR__."/vendor/autoload.php";


try {

    $router = new Router();

    $router->get("/blog",[BlogController::class,"list"]);

    Router::collection("/home",function (Router $router){

        $router->get("/zanko",[BlogController::class,"list"]);

        $router->get("/ferry",[BlogController::class,"all"])->name("ferry");
    });


}catch ( BadMethodCallException $e){
    echo "<br>";
    echo "<b>{$e}</b>";
}

