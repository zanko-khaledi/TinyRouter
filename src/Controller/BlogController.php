<?php

namespace App\Controller;


use App\Http\Request;
use App\Http\Response;

class BlogController
{


    public function list(Request $request,Response $response)
    {
         echo "Hello ".$request->get("name");
    }


    public function create(Request $request,Response $response)
    {
        echo  $request->input("name");
    }

    public function update()
    {
        echo  "update";
    }


    public function lastName(Request $request,Response $response)
    {
        echo  $response->json([
            "lastName" => $request->get("last")
        ]);
    }

}