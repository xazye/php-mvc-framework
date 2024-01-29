<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Response;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home(Requestsymfony $request, Response $response)
    {
        $params = [
            'name' => 'worldstuff2',
        ];
        return $this->render('home', $params);
    }

    public function contact(Requestsymfony $request, Response $response)
    {
        $contact =  new ContactForm();
        if($request->isMethod('post')){
            $contact->loadData($request->request->all());
            // add contact->send
            if($contact->validate()){
                Application::$APP->session->setFlash('success','Thanks for contacting us.');
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', ['model'=> $contact]);
    }
}
