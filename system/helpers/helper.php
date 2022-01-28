<?php

function dd($value, $die = true)
{
    var_dump($value);
    if ($die)
        exit();
}

function view($dir, $vars = [])
{
    $viewBuilder = new \System\View\ViewBuilder();
    $viewBuilder->run($dir);
    $viewVars = $viewBuilder->vars;
    $content = $viewBuilder->content;
    empty($viewVars) ?: extract($viewVars);
    empty($vars) ?: extract($vars);

    eval(" ?>" . html_entity_decode($content));
}

function html($text)
{
    return html_entity_decode($text);
}

function old($name)
{
    if (isset($_SESSION['temporary_old'][$name])) {
        return $_SESSION['temporary_old'][$name];
    }
    return null;
}

function flash($name, $message = null)
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_flash'][$name])) {
            $temporary = $_SESSION['temporary_flash'][$name];
            unset($_SESSION['temporary_flash'][$name]);
            return $temporary;
        }
        return false;
    }

    $_SESSION['flash'][$name] = $message;
}

function flashExists($name): bool
{
    return isset($_SESSION['temporary_flash'][$name]);
}

function allFlashes()
{
    if (isset($_SESSION['temporary_flash'])) {
        $temporary = $_SESSION['temporary_flash'];
        unset($_SESSION['temporary_flash']);
        return $temporary;
    }
    return false;
}

function error($name, $message = null)
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_error'][$name])) {
            $temporary = $_SESSION['temporary_error'][$name];
            unset($_SESSION['temporary_error'][$name]);
            return $temporary;
        }
        return false;
    }

    $_SESSION['error'][$name] = $message;
}

function errorExists($name): bool
{
    return isset($_SESSION['temporary_error'][$name]);
}

function allErrors()
{
    if (isset($_SESSION['temporary_error'])) {
        $temporary = $_SESSION['temporary_error'];
        unset($_SESSION['temporary_error']);
        return $temporary;
    }
    return false;
}

function currentDomain()
{
    $httpProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $currentUrl = $_SERVER['HTTP_HOST'];
    return $httpProtocol . $currentUrl;
}

function redirect($url)
{
    $url = trim($url, '/ ');
    $url = strpos($url, currentDomain()) === 0 ? $url : currentDomain() . '/' . $url;
    header('Location: ' . $url);
    exit();
}

function back()
{
    isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
}

function asset($src)
{
    return currentDomain() . '/' . trim($src, '/ ');
}