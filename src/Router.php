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

    private Request $request;
    private Response $response;

    private array $methods = [
        "get","post","patch","put","delete","group"
    ];

    private static array $static_methods= [
        "collection"
    ];

    private static ?string $request_method = null;
    private string $base_path = "/";
    private static ?string $collection_path = null;



    public function __construct()
    {

        if(self::$collection_path !== null){
            $this->base_path = self::$collection_path;
        }

       $this->request = new Request();
       $this->response = new Response();
    }


    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call(string $name,array $arguments)
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
    public function get(string $path, array | callable $handler):void
    {
         if($_SERVER['REQUEST_METHOD'] === self::GET_METHOD){
             self::$request_method = $_SERVER['REQUEST_METHOD'];

             if(is_callable($handler)){
                 $this->runCallbackFunc($path,$handler);
             }else{
                 $this->run($path,$handler);
             }
         }
    }


    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function post(string $path, array | callable $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === self::POST_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];

            if(is_callable($handler)){
                $this->runCallbackFunc($path,$handler);
            }else{
                $this->run($path,$handler);
            }
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function patch(string $path, array | callable $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === self::PATCH_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];

            if(is_callable($handler)){
                $this->runCallbackFunc($path,$handler);
            }else{
                $this->run($path,$handler);
            }
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function put(string $path, array | callable $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === self::PUT_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];

            if(is_callable($handler)){
                $this->runCallbackFunc($path,$handler);
            }else{
                $this->run($path,$handler);
            }
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    public function delete(string $path, array | callable $handler):void
    {
        if($_SERVER['REQUEST_METHOD'] === self::DELETE_METHOD){
            self::$request_method = $_SERVER['REQUEST_METHOD'];

            if(is_callable($handler)){
                $this->runCallbackFunc($path,$handler);
            }else{
                $this->run($path,$handler);
            }
        }
    }


    /**
     * @param string $collection
     * @param callable
     */
    public function group(string $collection,callable $handler)
    {
         $this->base_path = $collection;
         $handler($this);
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if(!in_array($name,self::$static_methods)){
            throw new BadMethodCallException("method {$name} doesn't exists!");
        }else{
            static::{$name}($arguments);
        }
    }

    /**
     * @param string $path
     * @param callable $callback
     */
    public static function collection(string $path,callable $callback):void
    {
         self::$collection_path = $path;
         $callback(new Router());
    }


    /**
     * @param string $path
     * @param callable $callback
     * @return void
     */
    private function runCallbackFunc(string $path, callable $callback)
    {

        $uri = $this->base_path === "/" ? $path : $this->base_path.$path;

        $request_uri = parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);

        if($request_uri === $uri && $_SERVER["REQUEST_METHOD"] === self::$request_method){
            $callback($this->request,$this->response);
        }
    }

    /**
     * @param string $path
     * @param array $handler
     * @throws Exception
     */
    private function run(string $path, array $handler)
    {
        $uri = $this->base_path === "/" ? $path : $this->base_path.$path;

        $request_uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

        $request_method = $_SERVER['REQUEST_METHOD'];

        if($uri === $request_uri && $request_method === self::$request_method){
            $this->handlerInstance($handler);
        }
    }


    /**
     * @param array $handler
     */
    private function handlerInstance(array $handler): void
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