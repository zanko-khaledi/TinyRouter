<?php

namespace App;

use App\Http\Request;
use App\Http\Response;
use BadMethodCallException;
use Exception;

class Router
{

    private const GET_METHOD = "GET";
    private const POST_METHOD = "POST";
    private const PUT_METHOD = "PUT";
    private const PATCH_METHOD = "PATCH";
    private const DELETE_METHOD = "DELETE";

    private array $methods = [
        "get","post","patch","put","delete","group"
    ];



    private static ?string $request_method = null;

    private ?string $base_path = null;

    private Request $request;
    private Response $response;


    public function __construct()
    {
       $this->request = new Request();
       $this->response = new Response();
    }


    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call(string $name, array $arguments)
    {
        if(!in_array($name,$this->methods)){
            throw new BadMethodCallException("method {$name} doesn't exists!");
        }else{
            $this->{$name}($arguments);
        }
    }


    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function get(string $path, array $handler):void
    {
         if($_SERVER['REQUEST_METHOD'] === self::GET_METHOD){
             self::$request_method = $_SERVER['REQUEST_METHOD'];
             $this->run($path,$handler);
         }
    }


    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function post(string $path, array $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === Router::POST_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];
            $this->run($path,$handler);
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function patch(string $path, array $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === Router::PATCH_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];
            $this->run($path,$handler);
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function put(string $path, array $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === Router::PUT_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];
            $this->run($path,$handler);
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function delete(string $path, array $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === Router::DELETE_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];
            $this->run($path,$handler);
        }
    }


    /**
     * @param string $collection
     * @param callable
     */
    public function group(string $collection,callable $handler)
    {
         $this->base_path = $collection;
         self::$request_method = $_SERVER['REQUEST_METHOD'];
         $handler($this);
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    protected function run(string $path, array $handler)
    {

        $real_path = $this->base_path !== null ? $this->base_path.$path : $path;

        $request_uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

        $request_method = $_SERVER['REQUEST_METHOD'];

        if($real_path === $request_uri && $request_method === self::$request_method){
            $this->handler_instance($handler);
        }
    }


    /**
     * @param array $handler
     */
    protected function handler_instance(array $handler): void
    {
        $instance = new $handler[0];
        $instance->{$handler[1]}($this->request,$this->response);
    }

    /**
     * @throws Exception
     */
    private function exceptionHandler(mixed $REQUEST_METHOD)
    {
        throw new Exception($REQUEST_METHOD);
    }

}