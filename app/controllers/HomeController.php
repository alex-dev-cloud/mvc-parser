<?php


namespace app\controllers;


use app\models\UserModel;
use core\Controller;
use core\Secure;
use core\Session;

class HomeController extends Controller
{
    public function index(){

        $data = [
            'title' => 'Home',
        ];

        if (isset($_GET['code'])) {
            $token = urldecode(Secure::treatData($_GET['code']));
            $MODEL = new UserModel();
            $MODEL->activate($token);
            Session::unsetMessage();
        }

        $this->view->render('home', $data);
    }
}