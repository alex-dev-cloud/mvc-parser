<?php


namespace core;


class View
{
    public function render($path, $data){
        require_once dirname(__DIR__) . '/app/views/header.php';
        require_once dirname(__DIR__) . '/app/views/' . $path . '.php';
        require_once dirname(__DIR__) . '/app/views/footer.php';
    }
}