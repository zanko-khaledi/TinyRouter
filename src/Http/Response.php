<?php

namespace App\Http;

require_once __DIR__."/../IResponse.php";


use App\IResponse;
use JetBrains\PhpStorm\NoReturn;

class Response implements IResponse
{

    /**
     * @param string|array|null $content
     * @param int $http_response_code
     */
    public function __construct(string | array $content = null,int $http_response_code = 200)
    {
        if(!is_null($content)){
            return $this->json($content,$http_response_code);
        }
    }

    /**
     * @param object|array|string $content
     * @param int $http_response_code
     * @return string
     */
    public function json(object|array|string $content, int $http_response_code=200): string
    {
        http_response_code($http_response_code);
        return  json_encode($content);
    }

    /**
     * @param string $path
     * @param int $http_response_code
     * @param array $headers
     */
    #[NoReturn] public function redirect(string $path, int $http_response_code, array $headers): void
    {
           header("Location : {$path}",true,$http_response_code);
           exit;
    }
}