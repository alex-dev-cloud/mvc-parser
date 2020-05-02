<?php


namespace app\models;

use core\DB;

class MovieModel
{
    public function saveMovie($id, $name, $img, $desc){
        $query = 'INSERT INTO movies (movie_id, name, image, description) VALUES (:id,:name,:img,:desc)';
        $statement = DB::prepare($query);

        $data = [
            'id' => $id,
            'name' => $name,
            'img' => $img,
            'desc' => $desc,
        ];
        return $statement->execute($data);
    }

    public function deleteMovies(){
        $query = 'DELETE FROM movies';
        return DB::exec($query);
    }

    public function getMovies($offset, $amount){
        $query = "SELECT movie_id,name,image,description FROM movies LIMIT $offset, $amount";
        $statement = DB::query($query);
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function countMovies(){
        $query = 'SELECT COUNT(*) as `total` FROM movies';
        $statement = DB::query($query);
        return $statement->fetch(\PDO::FETCH_OBJ);
    }
}