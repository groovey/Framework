<?php

namespace Groovey\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Groovey\Models\User;
use Groovey\Middlewares\Prototype as MiddlewarePrototype;

class Prototype implements ControllerProviderInterface
{
    public $session;

    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        $controller
            ->get('/', [$this, 'index'])
            ->bind('home')
            ->before([MiddlewarePrototype::class, 'before'])
            ->after([MiddlewarePrototype::class, 'after'])
        ;

        $controller
            ->get('/session/{id}', [$this, 'session'])
            ->assert('id', '\d+')
            ->value('id', 0)
            ->bind('prototype_edit');

        $controller->get('/trans/{locale}', [$this, 'trans']);
        $controller->get('/validation', [$this, 'validation']);
        $controller->match('/form', [$this, 'form']);

        return $controller;
    }

    public function index(Application $app)
    {

        $data = [
            'title' => 'Prototype'
        ];

        return $app->render('prototype.html', $data);

    }

    public function session(Application $app, $id)
    {
        $session = $app['session'];
        $faker   = $app['faker'];

        $session->set('user', [
                'id'       => $id,
                'username' => $faker->name,
            ]);

        $data = [
                'id'       => $session->get('user')['id'],
                'username' => $session->get('user')['username'],
            ];

        return $app->render('hello.html', $data);
    }

    public function trans(Application $app, $locale)
    {
        $app->setLocale($locale);

        $welcome = $app->trans('prototype.welcome');

        return new Response($welcome);
    }

    public function validation(Application $app)
    {
        try {
            $name = User::find(1)->name;

            $app->debug('user name = '.$name, 'hr');
        } catch (\Exception $e) {
            $app->debug('Whoops something went wrong.');
        }

        $data = [
            'name'     => 'Harold Kim',
            'password' => 'mysecretpassword',
        ];

        $errors = $app['validator']->validateValue($data, User::getContraints());

        if (count($errors) > 0) {
            $message = (string) $errors;
        } else {
            $message = 'Yay! all good. Saving record';
            $id = User::add($data);
            $app->debug('last insert id = '.$id);
        }

        $app->debug($message);

        return new Response(null);
    }

    public function form(Application $app, Request $request)
    {
        $data = [
            'name'  => 'Harold Kim',
            'email' => 'pokoot@gmail.com',
        ];

        $form = $app['form.factory']->createBuilder('form', $data)
            ->add('name')
            ->add('email')
            ->add('gender', 'choice', array(
                'choices' => array(1 => 'male', 2 => 'female'),
                'expanded' => true,
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            // $app->debug($data);
        }

        $data = [
            'form' => $form->createView(),
        ];

        return $app->render('form.html', $data);
    }
}
