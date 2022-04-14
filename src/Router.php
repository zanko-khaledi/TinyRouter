<?php

namespace App;

use App\Http\Request;
use App\Http\Response;
use BadMethodCallException;
use Exception as ExceptionAlias;


class Router
{

    private static array $instance = [];

    private const GET_METHOD = "GET";
    private const POST_METHOD = "POST";
    private const PUT_METHOD = "PUT";
    private const PATCH_METHOD = "PATCH";
    private const DELETE_METHOD = "DELETE";


    private static array $methods = [
        "execute","get", "post", "patch", "put", "delete", "collection"
    ];

    private static ?string $collection_path = "/";


    private function __construct()
    {

    }

    private function __clone(): void
    {

    }

    public function __serialize(): array
    {
        return unserialize(serialize());
    }


    /**
     * @param string $name
     * @param array $arguments
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (!in_array($name, static::$methods)) {
            throw new BadMethodCallException("Method {$name} not exists on this route!");
        }else{
            static::{$name}($arguments);
        }
    }

    /**
     * @throws ExceptionAlias
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * @return Router
     */
    public static function execute():Router
    {
        $class = static::class;

        if(!isset(static::$instance[$class])){
            static::$instance[$class] = new static();
        }

        return static::$instance[$class];
    }



    /**
     * @param string $path
     * @param callable $callback
     */
    public static function collection(string $path,callable $callback):void
    {
        static::$collection_path = $path;
        $callback(new Router());
    }


    /**
     * @param string $path
     * @param array|callable $handler
     */
    public static function get(string $path, array|callable $handler)
    {

        $path = static::$collection_path === "/" ? $path : static::$collection_path.$path;

        if($_SERVER["REQUEST_METHOD"] === static::GET_METHOD){
            static::run($path,$handler);
        }
    }

    /**
     * @param string $path
     * @param callable|array $handler
     * @throws ExceptionAlias
     */
    public static function post(string $path,callable | array $handler)
    {
       $path = static::$collection_path === "/" ? $path : static::$collection_path.$path;

       if($_SERVER["REQUEST_METHOD"] === static::POST_METHOD){
           static::run($path,$handler);
       }
    }

    /**
     * @param string $path
     * @param callable|array $handler
     * @throws ExceptionAlias
     */
    public static function put(string $path,callable | array $handler)
    {
       $path = static::$collection_path === "/" ? $path : static::$collection_path.$path;

       if($_SERVER["REQUEST_METHOD"] === static::PUT_METHOD){
           static::run($path,$handler);
       }
    }

    /**
     * @param string $path
     * @param callable|array $handler
     * @throws ExceptionAlias
     */
    public static function patch(string $path,callable | array $handler)
    {
        $path = static::$collection_path === "/" ? $path : static::$collection_path.$path;

        if($_SERVER["REQUEST_METHOD"] === static::PATCH_METHOD){
            static::run($path,$handler);
        }
    }

    /**
     * @param string $path
     * @param callable|array $handler
     * @throws ExceptionAlias
     */
    public static function delete(string $path,callable | array $handler)
    {
        $path = static::$collection_path === "/" ? $path : static::$collection_path.$path;

        if($_SERVER["REQUEST_METHOD"] === static::DELETE_METHOD){
            static::run($path,$handler);
        }
    }

    /**
     * @param $path
     * @param array|callable $handler
     * @throws ExceptionAlias
     */
    private static function run($path,array | callable $handler)
    {
        if(isset(static::$instance[Router::class])){

            $uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

            if($uri === $path){
                is_callable($handler) && !is_array($handler) ?
                    $handler(new Request(),new Response()) :  static::handleInstance($handler);
            }

        }else{
            throw new \Exception("Execute router singleton instance before initiate any route method eg: Router::execute()");
        }
    }

    /**
     * @param array $handler
     * @return void
     */
    private  static  function handleInstance(array $handler): void
    {
        $instance = new $handler[0];
        $instance->{$handler[1]}(new Request(),new Response());
    }
}

