<?php


namespace core;


class Validator
{
   static public function isEmpty($field){
       return empty($field);
   }

   static public function isLoginNotValid($login){
        return !preg_match('/^[a-z0-9_\.-]{4,16}$/i', $login);
   }

   static public function isEmailNotValid($email){
       return !filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   static public function isPasswordNotValid($password){
       return !preg_match('/^[a-z0-9_]{8,16}$/i', $password);
   }

   static public function isPasswordsDoesNotMatch($password, $passwordRepeat){
       return !($password === $passwordRepeat);
   }
}