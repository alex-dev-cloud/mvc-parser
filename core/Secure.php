<?php


namespace core;


class Secure
{
    static public function treatData($date){
        $date = trim($date);
        $date = htmlspecialchars($date);
        $date = stripslashes($date);
        return $date;
    }
}