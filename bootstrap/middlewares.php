<?php

use Symfony\Component\HttpFoundation\Request;

$app->before(function (Request $request) use ($app) {

    $path   = $request->getPathInfo();
    $method = $request->getMethod();
    $uri    = $request->getRequestUri();
    $route  = $request->get('_route');

});

$app->finish(function (Request $request) use ($app) {
});
