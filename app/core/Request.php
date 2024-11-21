<?php


class Request
{

    public $uri;
    public $method;

    public $data;

    function __construct()
    {

        $this->uri = $_SERVER['REQUEST_URI'];
        $this->data = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
}
