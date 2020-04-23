<?php


namespace app\controllers;


use core\Controller;

class PageController extends Controller
{
    public function index(){

        $data = [
            'title' => 'Pages',
        ];

        $this->view->render('page', $data);
    }
}