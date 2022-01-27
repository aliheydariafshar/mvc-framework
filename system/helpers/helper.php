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