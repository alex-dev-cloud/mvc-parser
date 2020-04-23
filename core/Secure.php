<?php


namespace core;


class Secure
{
    public static function treatData($date){
        $date = trim($date);
        $date = htmlspecialchars($date);
        $date = stripslashes($date);
        return $date;
    }
}