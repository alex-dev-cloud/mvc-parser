<?php


namespace app\controllers;


use core\Controller;
use PHPHtmlParser\Dom;

class PageController extends Controller
{
    public function index(){

        $data = [
            'title' => 'Pages',
        ];

        $this->view->render('page', $data);
    }

    public function parser(){
        $dom = new Dom();
        $dom->loadFromUrl('https://www.ivi.ru/movies/page');
        $films = $dom->find('.poster-badge');

        $result = [];

        for ($i=0; $i < 30 ; $i++) {
            if (!$films[$i]) break;
            $name = $films[$i]->find('.name')->innerHtml;
            $img = $films[$i]->find('img')->getAttribute('src');
            $id = $films[$i]->getAttribute('data-content-id');

            $href = $films[$i]->find('a')->getAttribute('href');
            $dom2 = new Dom;
            $dom2->loadFromUrl('https://www.ivi.ru'.$href);
            $desc = $dom2->find('.clause__text p')->innerHtml;

            $result[] = 'id: ' . $id;
            $result[] = 'name: ' . $name;
            $result[] = 'img: ' . $img;
            $result[] = 'desc: ' . $desc;

        }
        var_dump($result);
    }
}