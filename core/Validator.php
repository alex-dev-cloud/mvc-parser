<?php


namespace core;


class Validator
{
   public static function isEmpty($field){
       return empty($field);
   }

   public static function isLoginNotValid($login){
       return mb_strlen($login) < 3 || mb_strlen($login) > 16;
   }

   public static function isEmailNotValid($email){
       return !filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   public static function isPasswordNotValid($password){
       return mb_strlen($password) < 7 || mb_strlen($password) > 16;
   }

   public static function isPasswordsDoesNotMatch($password, $passwordRepeat){
       return !($password === $passwordRepeat);
   }
}