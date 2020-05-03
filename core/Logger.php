<?php


namespace core;


class Logger
{
    static public function putLog($name, $string){

        $path = dirname(__DIR__) . '/logs/' . $name . '.txt';
        $text = $string ."\t\t".date('Y-m-d H:i:s', time()). "\n";

        file_put_contents($path, $text, FILE_APPEND);
    }
}