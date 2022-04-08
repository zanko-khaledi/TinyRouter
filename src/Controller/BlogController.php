<?php

namespace App\Controller;


use App\Http\Request;
use App\Http\Response;
use App\Router;

require_once __DIR__."/../Router.php";

class BlogController
{


    public function list(Request $request,Response $response)
    {
         echo "Hello World";
    }


    public function all(Request $request,Response $response)
    {
         echo $response->json("Hello Ferry",200);
    }

}