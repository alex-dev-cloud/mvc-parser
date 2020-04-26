<?php


namespace app\controllers;


use app\models\MovieModel;
use core\Controller;
use PHPHtmlParser\Dom;

class MovieController extends Controller
{
    public function index(){

        $data = [
            'title' => 'Movies',
        ];

        $DB = new MovieModel();
        $totalMovies = $DB->countMovies()->total;
        $perPage = 5;
        $totalPages = $totalMovies/$perPage;

        $pageCurrent = (isset($_GET['page']) && !empty(intval($_GET['page']))) ? $_GET['page'] : 1;
        if ($pageCurrent > $totalPages) $pageCurrent = $totalPages;
        if ($pageCurrent < 1) $pageCurrent = 1;

        $offset = ($pageCurrent - 1) * $perPage;
        $data['movies'] = $DB->getMovies($offset, $perPage);
        $this->view->render('movie', $data);
    }

    public function parser(){
        $DB = new MovieModel();
        $DB->deleteMovies();
        $dom = new Dom();
        $dom->loadFromUrl('https://www.ivi.ru/movies/');
        $films = $dom->find('.poster-badge');

        for ($i=0; $i < 30 ; $i++) {
            if (!$films[$i]) break;
            $name = $films[$i]->find('.name')->innerHtml;
            $img = $films[$i]->find('img')->getAttribute('src');
            $id = $films[$i]->getAttribute('data-content-id');

            $href = $films[$i]->find('a')->getAttribute('href');
            $dom2 = new Dom;
            $dom2->loadFromUrl('https://www.ivi.ru'.$href);
            $desc = $dom2->find('.clause__text p')->innerHtml;

            $DB->saveMovie($id,$name,$img,$desc);
        }
        header('Location: /movie');
    }
}