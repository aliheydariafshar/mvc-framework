<?php

if (isset($_SESSION['old'])) {
    unset($_SESSION['temporary_old']);
    $_SESSION['temporary_old'] = $_SESSION['old'];
    unset($_SESSION['old']);
}

if (isset($_SESSION['flash'])) {
    unset($_SESSION['temporary_flash']);
    $_SESSION['temporary_flash'] = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

if (isset($_SESSION['error'])) {
    unset($_SESSION['temporary_error']);
    $_SESSION['temporary_error'] = $_SESSION['error'];
    unset($_SESSION['error']);
}
$params = [];
$params = isset($_GET) ? array_merge($params, $_GET) : $params;
$params = isset($_POST) ? array_merge($params, $_POST) : $params;
$_SESSION['old'] = $params;
unset($params);


require_once('../system/helpers/helper.php');
require_once('../config/app.php');
require_once('../config/database.php');

global $routes;
$routes = ['get' => [], 'post' => [], 'put' => [], 'delete' => []];
require_once('../routes/web.php');
require_once('../routes/api.php');

$routing = new \System\Router\Routing();
$routing->run();