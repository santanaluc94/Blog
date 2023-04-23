<?php

namespace App\Http;

class Request
{
    protected string $httpMethod;
    protected string $uri;
    protected array $queryParams;
    protected array $postVars;
    protected array $headers;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getPostVars(): array
    {
        return $this->postVars;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
