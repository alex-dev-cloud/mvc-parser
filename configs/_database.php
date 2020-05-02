<?php


$DB_DRIVER = getenv('DB_DRIVER') ?: 'mysql';
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_NAME = getenv('DB_NAME') ?: 'mvc-parser-to';
$DB_LOGIN = getenv('DB_LOGIN') ?: 'root';
$DB_PASSWORD = getenv('DB_PASSWORD') ?: 'root';
$DB_CHARSET = getenv('DB_CHARSET') ?: 'utf8';

define('DB_DRIVER', $DB_DRIVER);
define('DB_HOST', $DB_HOST);
define('DB_NAME', $DB_NAME);
define('DB_LOGIN', $DB_LOGIN);
define('DB_PASSWORD', $DB_PASSWORD);
define('DB_CHARSET', $DB_CHARSET);