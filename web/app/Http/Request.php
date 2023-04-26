<?php

namespace App\Http;

class Request
{
    protected string $httpMethod;
    protected string $uri;
    protected array $queryParams;
    protected array $postVars;
    protected array $headers;

    public function __construct(
        protected Router $router
    ) {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->setUri();
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setQueryParam(string $key, string|int|array|bool $value): self
    {
        $this->queryParams[$key] = $value;
        return $this;
    }

    public function getQueryParam(string $key): string|int|array|bool|null
    {
        return $this->queryParams[$key] ?? null;
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

    public function getRouter(): Router
    {
        return $this->router;
    }

    protected function setUri(): string
    {
        return $this->uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    }
}
