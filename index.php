<?php

use App\Controller\BlogController;
use App\Http\Request;
use App\Http\Response;
use App\Router;


require_once __DIR__."/vendor/autoload.php";


try {

    require_once __DIR__."/Routes/api.php";

}catch (Exception | BadMethodCallException $e){
    echo $e->getMessage();
}

