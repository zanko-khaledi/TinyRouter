<?php

namespace TinyRouter;

require __DIR__ . "/Request.php";

use TinyRouter\Request;

use BadMethodCallException;


class Router
{

    public Request $request;
    protected $request_uri;

    protected array $methods = [
        "GET", "POST", "PUT", "PATCH", "DELETE"
    ];

    public function __construct()
    {
        $this->request = new Request;
        $this->request_uri = $this->request->REQUEST_URI;
    }


    public function __call($name, $arguments)
    {
        if (in_array($name, $this->methods)) {
            call_user_func_array(["this", $name], $arguments);
        } else {
            throw new BadMethodCallException("Route method {$name} not exists. ");
        }
    }


    public function getFullUrl()
    {
        $http_protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
        $url = $http_protocol . "://" . $this->request->HTTP_HOST . $this->request_uri;

        return $url;
    }

    public function GET(string $path, callable $callbackFunc)
    {
        if (isset($_GET) && $this->request->REQUEST_METHOD == "GET") {
            $this->cheack_request($path, $callbackFunc);
        }
    }


    public function POST(string $path,callable $callbackFunc)
    {
        if (isset($_POST) && $this->request->REQUEST_METHOD == "POST") {
            $this->cheack_request($path,  $callbackFunc);
        }
    }

    public function PUT(string $path, callable $callbackFunc)
    {
        if ($this->request->REQUEST_METHOD == "PUT") {
            $this->cheack_request($path, $callbackFunc);
        }
    }

    public function PATCH(string $path, callable $callbackFunc)
    {
        if ($this->request->REQUEST_METHOD == "PATCH") {
            $this->cheack_request($path, $callbackFunc);
        }
    }


    public function DELTE(string $path, callable $callbackFunc)
    {
        if ($this->request->REQUEST_METHOD == "DELETE") {
            $this->cheack_request($path, $callbackFunc);
        }
    }


    private function cheack_request(string $path , callable $callbackFunc)
    {
        // uri path 
        $request_uri = parse_url($this->getFullUrl(), PHP_URL_PATH);
        $query = parse_url($this->getFullUrl(), PHP_URL_QUERY);
        // convert path to an array
        $split_path = preg_split("/\//", $path);
        // convert uri to an array
        $split_uri = explode("/", $request_uri);

        /**
         *   path like /example/term/:id
         * 
         *   uri like /example/term/25
         * 
         * 
         * 
         *   $params array cheacked the daynamic parameter which you want to 
         *   use
         *  
         * */

        $pattern = "/\:[0-9a-zA-Z]+/i";


        preg_match($pattern, implode("/", $split_path), $matches);


        $key_values = count($split_uri) == count($split_path) ?
            array_combine(array_values($split_path), array_values($split_uri))
            :
            null;


        if ($key_values != null) {

            $uri_to_compire = $matches != null ? 
            str_replace($key_values[$matches[0]], $matches[0], $request_uri)
            :
            $request_uri;

            if ($path == $uri_to_compire){
                if($matches != null){
                    call_user_func_array($callbackFunc, [$this->request, $key_values[$matches[0]], $query]);
                }else{
                    call_user_func_array($callbackFunc, [$this->request, $key_values, $query]);
                }
            }
        }
    }


    public function readirect(string $path)
    {
        if (!is_null($path)) {
            header("Location:" . $path);
        }
    }

    public function print_api($data, $status)
    {
        http_response_code($status ? $status : 200);
        echo json_encode($data);
    }
}
