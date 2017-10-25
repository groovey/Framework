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

        $controller->match('/forgot', [$this, 'forgot']);

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
        $method   = $request->getMethod();
        $username = $request->get('username');
        $password = $request->get('password');

        $app['trace']->show(true);

        if ($method && !$username) {
            $error = 'Username is required';
            // $app['session']->set('last_username', '');
        } elseif ($method && !$password) {
            $error = 'Password is required';
            // $app['session']->set('last_username', $username);
        } elseif ($method === 'POST') {
            $data = [
                'app'      => $app['config']->get('app.id'),
                'token'    => $app['config']->get('app.token'),
                'email'    => 'test1@gmail.com',
                'password' => 'test1',
            ];

            $response = $app['sso.client']->auth($data);
            $app['trace']->debug($response);

            die();

            // $app['trace']->debug($response);

            // TODO
            // if ($username === 'admin' && $password === 'ko') {
            //     // $app['session']->set('user', ['username' => $username]);

            //     return $app->redirect('/');
            // } else {
            //     $app['session']->set('last_username', $username);
            //     $error = 'Bad credentials';
            // }
        }

        $error = 'Invalid credentials';

        return $app['twig']->render('login.html', [
            'title'         => 'Login',
            'error'         => $error,
            // 'last_username' => $app['session']->get('last_username'),
        ]);
    }

    public function forgot(Application $app, Request $request)
    {
        return $app['twig']->render('forgot.html', [
            'title' => 'Forgot Password',
        ]);
    }
}
