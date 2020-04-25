<?php


namespace core;


class Validator
{
   public static function isEmpty($field){
       return empty($field);
   }

    public static function isLoginNotValid($login){
        return !preg_match('/^[a-z0-9_\.-]{4,16}$/i', $login);
    }

   public static function isEmailNotValid($email){
       return !filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   public static function isPasswordNotValid($password){
       return !preg_match('/^[a-z0-9_]{8,16}$/i', $password);
   }

   public static function isPasswordsDoesNotMatch($password, $passwordRepeat){
       return !($password === $passwordRepeat);
   }
}