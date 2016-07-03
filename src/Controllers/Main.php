<?php

namespace Groovey\Framework\Controllers;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Groovey\Framework\Middlewares\Main as MiddlewareMain;
use Groovey\Framework\Models\User;

class Main implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        $controller->match('/login', [$this, 'login']);
        $controller->match('/', [$this, 'index'])
            ->before([MiddlewareMain::class, 'before'])
            ->after([MiddlewareMain::class, 'after'])
        ;

        return $controller;
    }

    public function index(Application $app, Request $request)
    {
        $app->debug('Welcome to Groovey Page');

        return new Response('Welcome to the Groovey Homepage.');
    }

    public function login(Application $app, Request $request)
    {
        $error    = '';
        $username = $request->get('username');
        $password = $request->get('password');
        $submit   = $request->get('submit');

        if ($submit && !$username) {
            $error = 'Username is required';
            $app['session']->set('last_username', '');
        } elseif ($submit && !$password) {
            $error = 'Password is required';
            $app['session']->set('last_username', $username);
        } elseif ($submit) {

            // TODO
            if ($username === 'admin' && $password === 'ko') {
                $app['session']->set('user', ['username' => $username]);

                return $app->redirect('/');
            } else {
                $app['session']->set('last_username', $username);
                $error = 'Bad credentials';
            }
        }

        return $app['twig']->render('login.html', [
            'error'         => $error,
            'last_username' => $app['session']->get('last_username'),
        ]);
    }
}
