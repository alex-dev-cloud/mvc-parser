<?php


namespace app\models;


use core\Model;

class UserModel extends Model
{
    public function getAllUsers(){
        return $this->db->query('SELECT * FROM users')->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getOneByLogin($login){
        $query = 'SELECT * FROM users WHERE login=:login';
        $statement = $this->db->prepare($query);
        $data = [
            'login' => strtolower($login),
        ];
        $statement->execute($data);
        return $statement->fetch(\PDO::FETCH_OBJ);
    }
    public function getOneByEmail($email){
        $query = 'SELECT * FROM users WHERE email=:email';
        $statement = $this->db->prepare($query);
        $data = [
            'email' => $email,
        ];
        $statement->execute($data);
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function saveUser($data){
        $query = 'INSERT INTO users (login,email,password,reg_ip,reg_uagent,reg_date) VALUES (:login,:email,:password,:ip,:ua,NOW())';
        $statement = $this->db->prepare($query);
        $data = [
            'login' => strtolower($data['login']),
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'ua' => $_SERVER['HTTP_USER_AGENT'],
        ];
        $statement->execute($data);
        return $statement;
    }
}