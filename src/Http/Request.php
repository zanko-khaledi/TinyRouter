<?php

namespace App\Http;

require_once __DIR__."/../IRequest.php";

use App\IRequest;

use Exception;

class Request implements IRequest
{

    /**
     * @var object
     */
    private object $request;


    public function __construct()
    {
        $request = [];

        foreach ($_SERVER as $key => $value){
            $request[strtolower($key)] = $value;
        }

        $this->request = (object)$request;
    }

    /**
     * @return object
     */
    public function getServerObject():object
    {
        return $this->request;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $_GET[$key];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function post(string $key):mixed
    {
        return $_POST[$key];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function input(string $key): mixed
    {
        return json_decode(file_get_contents("php://input"))->{$key};
    }

    /**
     * @param array $keys
     * @return mixed|void
     */
    public function only(array $keys):array
    {
        if(in_array($keys,json_decode(file_get_contents("php://input"),true))){
            return json_decode(file_get_contents("php://input"));
        }
    }

    /**
     * @return string|bool
     */
    public function getContent(): string|bool
    {
        return json_decode(file_get_contents("php://input"));
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function getRequest(string $key = null): mixed
    {
        return $key === null ? $_REQUEST : $_REQUEST[$key];
    }

    /**
     * @return array
     */
    public function queryString(): array
    {
        return $_GET;
    }


    /**
     * @throws Exception
     */
    public function exceptionHandler(string $key = null): Exception
    {
        throw new Exception("{$key} doesn't exists on get request ");
    }

    /**
     * @return array|null
     */
    public function __debugInfo(): ?array
    {
        return (array)$this->request;
    }

}