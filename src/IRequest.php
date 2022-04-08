<?php

namespace App;

interface IRequest
{

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;

    /**
     * @param string $key
     * @return mixed
     */
    public function post(string $key) : mixed;

    /**
     * @param string $key
     * @return mixed
     */
    public function input(string $key): mixed;

    /**
     * @param array $keys
     * @return mixed
     */
    public function only(array $keys): mixed;

    /**
     * @return mixed
     */
    public function getContent(): mixed;

    /**
     * @return mixed
     */
    public function getRequest(?string $key=null):mixed;

    /**
     * @return mixed
     */
    public function queryString(): mixed;

    /**
     * @param string|null $key
     * @return mixed
     */
    public function exceptionHandler(string $key=null): mixed;

}