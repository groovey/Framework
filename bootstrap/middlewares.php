<?php

/**
 * General Middlewares.
 */
use Symfony\Component\HttpFoundation\Request;

$app->before(function (Request $request) use ($app) {

    $path   = $request->getPathInfo();
    $method = $request->getMethod();
    $uri    = $request->getRequestUri();
    $route  = $request->get('_route');

    // $app->debug('method    = ' . $method);
    // $app->debug('uri       = ' . $uri);
    // $app->debug('path info = ' . $path);
    // $app->debug('route     = ' . $route);

});

$app->finish(function (Request $request) use ($app) {
    // $app->debug('end');
});
