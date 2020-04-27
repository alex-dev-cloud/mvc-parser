<?php


namespace app\controllers;


use app\models\PostModel;
use core\Controller;
use core\Paginator;
use core\Secure;
use core\Validator;

class PostController extends Controller
{
    private $MODEL;

    public function __construct()
    {
        $this->MODEL = new PostModel();
        parent::__construct();
    }

    public function index(){

        $data = [
            'title' => 'Posts',
        ];

        $totalPosts = $this->MODEL->countPosts()->total;
        $perPage = 5;

        $data['paginator'] = new Paginator($totalPosts, $perPage, 'post');
        $offset = ($data['paginator']->getCurrentPage() - 1) * $perPage;
        $data['posts'] = $this->MODEL->getPosts($offset, $perPage);
        $this->view->render('posts', $data);

    }

    public function save(){
        if (empty($_POST) || empty($_SESSION['user'])) header('Location: /post');
        else {
            $data = [
                'title' => Secure::treatData($_POST['title']),
                'content' => Secure::treatData($_POST['content']),
                'created' => time(),
                'user' => $_SESSION['user']->id,
            ];
            $response = [
                'success' => true,
                'titleError' => NULL,
                'contentError' => NULL,
            ];
            if (Validator::isEmpty($data['title'])) {
                $response['success'] = false;
                $response['titleError'] = 'Please, fill the title of your post';
            }
            if (Validator::isEmpty($data['content'])) {
                $response['success'] = false;
                $response['contentError'] = 'Your message is empty';
            }
            if ($response['success']){
                $this->MODEL->savePost($data);
            }
            echo json_encode($response);
        }
    }
}