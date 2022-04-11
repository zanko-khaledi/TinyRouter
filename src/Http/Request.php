<?php

namespace App\Http;

require_once __DIR__."/../IRequest.php";
use App\IRequest;

use Exception;
use stdClass;


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
        return $_GET[$key] ?? $_GET;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function post(string $key):mixed
    {
        return $_POST[$key] ?? $_POST;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function input(string $key): mixed
    {
        return json_decode(file_get_contents("php://input"))->{$key} ?? new stdClass();
    }

    /**
     * @return stdClass|array|string
     */
    public function getContent():stdClass | array | string
    {
        return json_decode(file_get_contents("php://input"));
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function getRequest(string $key = null): mixed
    {
        return $_REQUEST[$key] ?? $_REQUEST;
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