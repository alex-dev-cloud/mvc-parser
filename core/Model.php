<?php


namespace core;


class Model
{
    protected $db;

    public function __construct()
    {
        $dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $login = DB_LOGIN;
        $password = DB_PASSWORD;

        try {
            $this->db = new \PDO($dsn, $login, $password);
        } catch (\PDOException $exception) {
            echo '<h1>Data base connection error</h1>';
        }

        foreach (TABLES as $TABLE) {
            if (!empty($TABLE)) $this->db->exec($TABLE);
        }
    }
}