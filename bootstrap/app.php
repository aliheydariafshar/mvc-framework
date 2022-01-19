<?php

function dd($var)
{
    print ('<pre>');
    print_r($var);
    exit();
}

require_once('../config/app.php');
require_once('../config/database.php');

require_once('../routes/web.php');
require_once('../routes/api.php');
$post = \App\Category::find(1)->posts()->get();
dd($post);
$routing = new \System\Router\Routing();
$routing->run();