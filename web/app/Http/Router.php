<?php

namespace App\Http;

use App\Http\Response;
use Closure;
use Exception;

class Router
{
    protected const GET_METHOD = 'GET';
    protected const POST_METHOD = 'POST';

    protected string $prefix = '';
    protected array $routes = [];
    protected Request $request;

    public function __construct(
        protected string $url
    ) {
        $this->request = new Request();
        $this->setPrefix();
    }

    public function get(string $route, array $params = []): void
    {
        $this->addRoute(self::GET_METHOD, $route, $params);
    }

    public function post(string $route, array $params = []): void
    {
        $this->addRoute(self::POST_METHOD, $route, $params);
    }

    public function run(): Response
    {
        try {
            $route = $this->getRoute();

            if (!isset($route['controller'])) {
                throw new Exception('URL não pode ser processada.', 500);
            }

            $args = [];

            return call_user_func_array($route['controller'], $args);
        } catch (Exception $exception) {
            return new Response($exception->getCode(), $exception->getMessage());
        }
    }

    protected function setPrefix(): void
    {
        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';
    }

    protected function addRoute(string $method, string $route, array $params): void
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
            }
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        $this->routes[$patternRoute][$method] = $params;
    }

    protected function getRoute(): array
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri)) {
                if ($methods[$httpMethod]) {
                    return $methods[$httpMethod];
                }

                throw new Exception('Método não permitido.', 405);
            }
        }

        throw new Exception('URL não encontrada.', 404);
    }

    protected function getUri(): string
    {
        $uri = $this->request->getUri();
        $newUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($newUri);
    }
}
