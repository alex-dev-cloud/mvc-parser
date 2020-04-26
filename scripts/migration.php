<?php

require_once dirname(__DIR__) . '/configs/_database.php';
require_once dirname(__DIR__) . '/configs/_migration.php';

$dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
$login = DB_LOGIN;
$password = DB_PASSWORD;

try {
    $DB = new \PDO($dsn, $login, $password);
} catch (\PDOException $exception) {
    echo 'Data base connection error '.$exception->getMessage();
}

foreach (TABLES as $TABLE) {
    if (!empty($TABLE)) $DB->exec($TABLE);
}
