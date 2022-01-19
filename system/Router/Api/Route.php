<?php


namespace System\Router\Api;


class Route
{
    public static function get($url, $executeMethod, $name = null)
    {
        [$class, $method] = explode('@', $executeMethod);
        global $routes;
        array_push($routes['get'], [
            'url' => 'api/' . trim($url, '/ '),
            'class' => $class,
            'method' => $method,
            'name' => $name
        ]);
    }

    public static function post($url, $executeMethod, $name = null)
    {
        [$class, $method] = explode('@', $executeMethod);
        global $routes;
        array_push($routes['post'], [
            'url' => 'api/' . trim($url, '/ '),
            'class' => $class,
            'method' => $method,
            'name' => $name
        ]);
    }
}