<?php


namespace app\models;


use core\DB;

class PostModel
{
    public function getPosts($offset, $amount){
        $query = "SELECT p.id, p.title, p.created, p.content, u.login FROM posts p INNER JOIN users u ON p.user_id = u.id LIMIT $offset, $amount";
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

        return $statement->execute($data);
    }

    public function deletePost($id){
        $query = 'DELETE FROM posts WHERE id = :id';
        $statement = DB::prepare($query);

        $data = [
            'id' => $id,
        ];

        return $statement->execute($data);
    }

}