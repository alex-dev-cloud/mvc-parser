<?php


namespace app\models;


use core\Model;

class MovieModel extends Model
{
    public function saveMovie($id, $name, $img, $desc){
        $query = 'INSERT INTO movies (movie_id, name, image, description) VALUES (:id,:name,:img,:desc)';
        $statement = $this->db->prepare($query);

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
        return $this->db->exec($query);
    }

    public function getMovies(){
        $query = 'SELECT movie_id,name,image,description FROM movies';
        $statement = $this->db->query($query);
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}