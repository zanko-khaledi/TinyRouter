<?php

namespace App\Controller;


use App\Http\Request;
use App\Http\Response;

class BlogController
{


    public function list(Request $request,Response $response)
    {
         echo $response->json("Hello World",200);
    }


    public function all(Request $request,Response $response)
    {
         echo $response->json("Hello Ferry",200);
    }

}