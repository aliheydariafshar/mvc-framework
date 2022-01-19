<?php


namespace System\Router;


use ReflectionMethod;

class Routing
{
    private $current_route;
    private $method_field;
    private $routes;
    private $values = [];

    public function __construct()
    {
        $this->current_route = explode('/', CURRENT_ROUTE);
        $this->method_field = $this->methodField();
        global $routes;
        $this->routes = $routes;
    }

    public function run()
    {
        $match = $this->match();
        if (!$match) {
            $this->error404();
        }
        $classPath = str_replace('\\', '/', $match['class']);
        $path = BASE_DIR . '/App/Http/Controllers/' . $classPath . '.php';
        if (!file_exists($path)) {
            $this->error404();
        }

        $class = "\App\Http\Controllers\\" . $match['class'];
        $object = new $class;
        if (method_exists($object, $match['method'])) {
            $reflection = new ReflectionMethod($object, $match['method']);
            $parameterCount = $reflection->getNumberOfParameters();
            if ($parameterCount <= count($this->values)) {
                call_user_func_array([$object, $match['method']], $this->values);
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }

    public function match()
    {
        $reservedRoutes = $this->routes[$this->method_field];
        foreach ($reservedRoutes as $reservedRoute) {
            if ($this->compare($reservedRoute['url'])) {
                return ['class' => $reservedRoute['class'],
                    'method' => $reservedRoute['method']];
            }
            $this->values = [];
        }
        return [];
    }

    private function compare($reservedRouteUrl)
    {
        //part1
        if (trim($reservedRouteUrl, '/') === '') {
            return trim($this->current_route[0], '/') === '';
        }

        //part2
        $reservedRouteUrlArray = explode('/', $reservedRouteUrl);
        if (sizeof($this->current_route) != sizeof($reservedRouteUrlArray)) {
            return false;
        }

        //part3
        foreach ($this->current_route as $key => $currentRouteElement) {
            $reservedRouteElement = $reservedRouteUrlArray[$key];
            if (substr($reservedRouteElement, 0, 1) === '{' &&
                substr($reservedRouteElement, -1) === '}') {
                array_push($this->values, $currentRouteElement);
            } elseif ($reservedRouteElement != $currentRouteElement) {
                return false;
            }
        }
        return true;

    }

    public function error404()
    {
        http_response_code(404);
        include __DIR__ . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . '404.php';
        exit;
    }

    public function methodField()
    {
        $method_field = strtolower($_SERVER["REQUEST_METHOD"]);
        if ($method_field == 'post' && $_POST["_method"] == 'put') {
            $method_field = 'put';
        } elseif ($method_field == 'post' && $_POST["_method"] == 'delete') {
            $method_field = 'delete';
        }
        return $method_field;
    }
}