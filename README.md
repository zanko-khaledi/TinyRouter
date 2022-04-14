TinyRouter

For use this module to you'r php pure project's you should first 
download the release and execute Router instance on "index.php" root project.

eg:
 
#### index.php
####<?php

  
    
    use \App\Router;
    use \App\Http;

    require_once __DIR__."/TinyRouter/src/Router.php";

    try{

        Router::execute();

        Router::get("/bar",function(Request $request,Response $response){
           echo $response->json('Hello World',200);
         });

        /* 
        * for collections
        */

        Router::collection("/home",function(){
           Router::get("/blog",[BlogController,"list"]);
           Router::post("/blog/create",[BlogController,"create"]);
         });

       /*
        * other route methods(post,put,patch,delete)
        */

     } catch(Exception | BadMethodCallException $e){
         echo $e->getMessage();
     }
