<?php

namespace core;

class Session
{
    static public function init(){
        session_start();
    }

    static public function destroy(){
        session_destroy();
    }

    static public function setUser($user = true){
        $_SESSION['user'] = $user;
    }

    static public function stopSession(){
        session_destroy();
        unset($_SESSION['user']);
    }

    static public function setMessage($message){
        $_SESSION['message'] = $message;
    }

    static public function getMessage($key){
        if (isset($_SESSION['user']['message'][$key])) return $_SESSION['user']['message'][$key];
        else return false;
    }

    static public function unsetMessage(){
        unset($_SESSION['message']);
    }

    static public function checkUser(){
        return isset($_SESSION['user']);
    }
}