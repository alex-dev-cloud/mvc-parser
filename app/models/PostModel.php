<?php


namespace app\models;


use core\DB;

class PostModel
{
    public function getPosts($offset, $amount){
        $query = "SELECT * FROM posts LIMIT $offset, $amount";
        $statement = DB::query($query);
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
    public function countPosts(){
        $query = 'SELECT COUNT(*) as `total` FROM posts';
        $statement = DB::query($query);
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function savePost($data){
        $query = 'INSERT INTO posts (title, content, created, user_id) VALUES (:title, :content, :created, :user)';
        $statement = DB::prepare($query);

        $data = [
            'title' => $data['title'],
            'content' => $data['content'],
            'created' => $data['created'],
            'user' => $data['user'],
        ];

        $statement->execute($data);
    }
}