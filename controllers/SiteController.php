<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => 'worldstuff2',
        ];
        return $this->render('home', $params);
    }

    public function contact()
    {
        $params = [
            'name' => 'worldstuff',
        ];
        return $this->render('contact', $params);
    }

    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        return "handling submitted data";
    }
}
