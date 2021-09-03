<?php

namespace TinyRouter;

use BadMethodCallException;

class Request
{

    protected $requests = [];
    protected $methods = [
        "get", "post", "put", "delete", "patch", "has"
    ];

    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            $this->requests[$key] = $value;
        }
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, $this->methods)) {
            if (isset($_REQUEST[$arguments])) {
                call_user_func_array(['this', $name], $arguments);
            }
        } else {
            throw new BadMethodCallException();
        }
    }

    public static function RequestExists($name)
    {
        if (array_key_exists($name, $_REQUEST)) {
            return true;
        } else {
            return false;
        }
    }

    public function __get($name)
    {
        $request_name = strtoupper($name);
        return $this->requests[$request_name];
    }


    public function get($arguments)
    {
        if (isset($_GET[$arguments])) {
            return $_GET[$arguments];
        }
    }
    public function post($arguments)
    {
        if(isset($_POST[$arguments])){
            return $_POST[$arguments];
        }
    }
    public function delete($arguments)
    {
        if (isset($_POST[$arguments])) {
            return $_POST[$arguments];
        }
    }
    public function patch($arguments)
    {
        if (isset($_POST[$arguments])) {
            return $_POST[$arguments];
        }
    }
    public function put($arguments)
    {
        if (isset($_POST[$arguments])) {
            return $_POST[$arguments];
        }
    }


    public function getContents($data){
         return  file_get_contents($data);
    }

    // public function __debugInfo()
    // {
    //     foreach ($this->requests as $k => $v) {
    //         echo $k . ' => ' . $v . '<br>';
    //     }
    // }
}
