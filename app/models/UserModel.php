<?php


namespace app\models;


use core\DB;

class UserModel
{

    public function getAllUsers(){
        return DB::query('SELECT * FROM users')->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getActivatedUsers(){
        return DB::query("SELECT * FROM users WHERE is_active = '1'")->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getOneByLogin($login){
        $query = 'SELECT * FROM users WHERE login=:login';
        $statement = DB::prepare($query);
        $data = [
            'login' => strtolower($login),
        ];
        $statement->execute($data);
        return $statement->fetch(\PDO::FETCH_OBJ);
    }
    public function getOneByEmail($email){
        $query = 'SELECT * FROM users WHERE email=:email';
        $statement = DB::prepare($query);
        $data = [
            'email' => $email,
        ];
        $statement->execute($data);
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function saveUser($data){
        $query = 'INSERT INTO users (login,email,password,token_email,reg_ip,reg_uagent,reg_date) VALUES (:login,:email,:password,:token,:ip,:ua,NOW())';
        $statement = DB::prepare($query);
        $data = [
            'login' => strtolower($data['login']),
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'token' => $data['token'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'ua' => $_SERVER['HTTP_USER_AGENT'],
        ];
        $statement->execute($data);
        return $statement;
    }

    public function activate($token){
        $query = "UPDATE users SET is_active = '1' WHERE token_email = :token";
        $statement = DB::prepare($query);
        $data = [
            'token' => $token,
        ];
        return $statement->execute($data);
    }
}