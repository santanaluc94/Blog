<?php

namespace App\Http;

use App\Http\Response;
use ReflectionFunction;
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
        $this->request = new Request($this);
        $this->setPrefix();
    }

    public function get(string $route, array $params): void
    {
        $this->addRoute(self::GET_METHOD, $route, $params);
    }

    public function delete(string $route, array $params): void
    {
        $this->addRoute(self::GET_METHOD, $route, $params);
    }

    public function post(string $route, array $params): void
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
            $reflection = new ReflectionFunction($route['controller']);

            foreach ($reflection->getParameters() as $param) {
                $name = $param->getName();
                $args[$name] = $route['vars'][$name] ?? '';
            }

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

    protected function addRoute(
        string $method,
        string $route,
        array $params
    ): void {
        $params['vars'] = [];
        $patternVar = '/{(.*?)}/';

        if (preg_match_all($patternVar, $route, $matches)) {
            $route = preg_replace($patternVar, '?(.*?)', $route);
            $params['vars'] = $matches[1];
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        $this->routes[$patternRoute][$method] = $params;
    }

    protected function getRoute(): array
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri, $matches)) {
                if (isset($methods[$httpMethod])) {
                    if (isset($matches[1])) {
                        $this->request->setQueryParam('id', (int) $matches[1]);
                    }
                    unset($matches[0]);

                    $keys = $methods[$httpMethod]['vars'];
                    $methods[$httpMethod]['vars'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['vars']['request'] = $this->request;
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

    public function redirect($route): void
    {
        header("Location: " . URL . $route);
        exit();
    }
}
