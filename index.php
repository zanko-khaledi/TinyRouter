<?php

use App\Controller\BlogController;
use App\Router;


require_once __DIR__."/vendor/autoload.php";


try {

    $router = new Router();

    $router->get("/blog",[BlogController::class,"list"]);

    Router::collection("/home",function (Router $router){

        $router->get("/zanko",[BlogController::class,"list"]);

        $router->get("/teddy",function (\App\Http\Request $request,\App\Http\Response $response){
            echo  $response->json([
                "name" => $request->get("name") ? : "zanko"
            ]);
        });

        $router->get("/ferry",[BlogController::class,"all"]);

        $router->post("/create",function (\App\Http\Request $request,\App\Http\Response $response){
            echo  $response->json($request->getRequest());
        });
    });

    $router->patch("/blog/zanko",[BlogController::class,"update"]);
}catch ( BadMethodCallException $e){
    echo "<br>";
    echo "<b>{$e}</b>";
}

