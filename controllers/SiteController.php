<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;
use Symfony\Component\HttpFoundation\Response as Responsesymfony;
use app\models\ContactForm;
class SiteController extends Controller
{
    public function home($name)
    {
        return new Responsesymfony($this->render('home', $name));
    }
    public function contact(Requestsymfony $request):Responsesymfony
    {
        $contact =  new ContactForm();
        // var_dump($request);
        if($request->isMethod('post')){
            $contact->loadData($request->request->all());
            // add contact->send
            if($contact->validate()){
                Application::$APP->session->setFlash('success','Thanks for contacting us.');
                // return $response->redirect('/contact');
            }
        }
        return new Responsesymfony($this->render('contact', ['model'=> $contact]));
    }
}
