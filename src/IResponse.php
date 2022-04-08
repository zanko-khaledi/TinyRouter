<?php

namespace App;

interface IResponse
{
    /**
     * @param array|object|string $content
     * @param int $http_response_code
     */
    public function json(array | object | string $content ,int $http_response_code):string;


    /**
     * @param string $path
     * @param int $http_response_code
     * @param array $headers
     */
    public function redirect(string $path,int $http_response_code,array $headers):void;

}