<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {

    if ($app['config']->get('app.debug')) {
        return;
    }

    $message = $e->getMessage();

    $templates = [
        $code.'.html',
        substr($code, 0, 2).'x.html',
        substr($code, 0, 1).'xx.html',
        'default.html',
    ];

    return new Response($app['twig']
                            ->resolveTemplate($templates)
                            ->render(['title' => $code]));

});

return $app;
