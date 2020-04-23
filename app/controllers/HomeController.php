<?php


namespace app\controllers;


use core\Controller;

class HomeController extends Controller
{
    public function index(){

        $data = [
            'title' => 'Home',
        ];

        $this->view->render('home', $data);
    }
}