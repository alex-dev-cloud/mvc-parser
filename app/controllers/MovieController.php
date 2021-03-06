<?php


namespace app\controllers;


use app\models\MovieDB;
use app\models\MovieModel;
use core\Controller;
use core\Logger;
use core\Paginator;
use PHPHtmlParser\Dom;

class MovieController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MovieModel();
    }

    public function index(){

        $data = [
            'title' => 'Movies',
        ];

        $totalMovies = $this->model->countMovies()->total;
        $perPage = 5;

        $data['paginator'] = new Paginator($totalMovies, $perPage, 'movie');
        $offset = ($data['paginator']->getCurrentPage() - 1) * $perPage;
        $data['movies'] = $this->model->getMovies($offset, $perPage);
        $this->view->render('movie', $data);
    }

    public function parser(){
        Logger::putLog('heroku', 'parser start...');
        ini_set('max_execution_time', 180);

        $dom = new Dom();
        $dom->loadFromUrl('https://www.ivi.ru/collections/popular-movies');
        $films = $dom->find('.poster-badge');

        for ($i=0; $i < 40 ; $i++) {
            if (!$films[$i]) break;
            $name = $films[$i]->find('.name')->innerHtml;
            $img = $films[$i]->find('img')->getAttribute('src');
            $id = $films[$i]->getAttribute('data-content-id');

            $href = $films[$i]->find('a')->getAttribute('href');
            $dom2 = new Dom;
            $dom2->loadFromUrl('https://www.ivi.ru'.$href);
            $desc = $dom2->find('.clause__text p')->innerHtml;

            $this->model->saveMovie($id,$name,$img,$desc);
            Logger::putLog('heroku', "save to database - $i");
        }
        Logger::putLog('heroku', 'parser finish');
        header('Location: /movie');
    }
}