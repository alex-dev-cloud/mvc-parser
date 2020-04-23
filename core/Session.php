<?php

namespace core;

class Session
{
    public static function init(){
        session_start();
    }

    public static function destroy(){
        session_destroy();
    }

    public static function setUser($user = true){
        $_SESSION['user'] = $user;
    }

    public static function stopSession(){
        session_destroy();
        unset($_SESSION['user']);
    }

    public static function setMessage($key, $value){
        $_SESSION['user']['message'][$key] = $value;
    }

    public static function getMessage($key){
        if (isset($_SESSION['user']['message'][$key])) return $_SESSION['user']['message'][$key];
        else return false;
    }

    public static function unsetMessage($key){
        unset($_SESSION['user']['message'][$key]);
    }

    public static function checkUser(){
        return isset($_SESSION['user']);
    }
}