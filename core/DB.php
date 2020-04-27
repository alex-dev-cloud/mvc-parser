<?php


namespace core;


class DB
{
    static private $instance = NULL;
    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    static private function getInstance(){
        if (is_null(self::$instance)) {
            $dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            $login = DB_LOGIN;
            $password = DB_PASSWORD;
            try {
                self::$instance = new \PDO($dsn, $login, $password);
            } catch (\PDOException $exception) {
                echo '<h1>Data base connection error</h1>';
            }
        }
    }

    static public function __callStatic($method, $arguments)
    {   self::getInstance();
        return call_user_func_array(array(self::$instance, $method), $arguments);
    }
}