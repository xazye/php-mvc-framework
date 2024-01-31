<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;
use app\models\ContactForm;
class SiteController extends Controller
{
    public function home($name)
    {
        return $this->render('home', $name);
    }
    public function contact(Requestsymfony $request)
    {
        $contact =  new ContactForm();
        if($request->isMethod('post')){
            
            $contact->loadData($request->request->all());
            // add contact->send
            if($contact->validate()){
                Application::$APP->session->setFlash('success','Thanks for contacting us.');
                return new RedirectResponse('/contact',301);
            }
        }
        return $this->render('contact', ['model'=> $contact]);
    }
}
