<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => 'worldstuff2',
        ];
        return $this->render('home', $params);
    }

    public function contact(Request $request, Response $response)
    {
        $contact =  new ContactForm();
        if($request->isPost()){
            $contact->loadData($request->getBody());
            // add contact->send
            if($contact->validate()){
                Application::$APP->session->setFlash('success','Thanks for contacting us.');
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', ['model'=> $contact]);
    }
}
