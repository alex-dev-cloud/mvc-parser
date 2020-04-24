<?php


namespace app\controllers;


use app\models\UserModel;
use core\Controller;
use core\Secure;
use core\Session;
use core\Validator;

class UserController extends Controller
{

    public function index(){
        $DB = new UserModel();


        $users = $DB->getAllUsers();

        $data = [
            'title' => 'Users',
            'users' => $users,
        ];
        $this->view->render('users', $data);
    }
    public function login(){
        if (Session::checkUser()) {
            header('Location: /');
        } else {

            if (!empty($_POST)) {
                $response = [
                    'success' => false,
                    'loginError' => false,
                    'passwordError' => false,
                ];


                $DB = new UserModel();

                $data = [
                    'title' => 'Registration',
                    'login' => Secure::treatData($_POST['login']),
                    'password' => Secure::treatData($_POST['password']),
                ];

                if (Validator::isEmpty($data['login'])) $response['loginError'] = 'Please, fill this field';
                if (Validator::isEmpty($data['password'])) $response['passwordError'] = 'Please, fill this field';

                if (!$response['loginError'] && !$response['passwordError']) {
                    if ($user = $DB->getOneByLogin($data['login'])) {
                        if (password_verify($data['password'], $user->password)) $response['success'] = true;
                        else {
                            $response['loginError'] = 'Wrong login or password';
                            $response['passwordError'] = 'Wrong login or password';
                        }
                    } else {
                        $response['loginError'] = 'Wrong login or password';
                        $response['passwordError'] = 'Wrong login or password';
                    };
                }

                if ($response['success']) {
                    Session::setUser($user);
                }
                echo json_encode($response);
            } else {
                $data = [
                    'title' => 'Login',
                ];
                $this->view->render('login', $data);
            }
        }
    }

    public function logout(){
        if (Session::checkUser()) {
            Session::destroy();
            header('Location: /user/login');
        } else {
            header('Location: /');
        }
    }

    public function registration(){
        if (Session::checkUser()) {
            header('Location: /');
        } else {
            if (!empty($_POST)) {

                $DB = new UserModel();

                $data = [
                    'title' => 'Registration',
                    'login' => Secure::treatData($_POST['login']),
                    'email' => Secure::treatData($_POST['email']),
                    'password' => Secure::treatData($_POST['password']),
                    'passwordRepeat' => Secure::treatData($_POST['passwordRepeat']),
                ];

                $response = [
                    'success' => true,
                    'loginError' => false,
                    'emailError' => false,
                    'passwordError' => false,
                    'passwordRepeatError' => false,
                ];

                #============ USER DATA VALIDATION =======================================#

                #---------------login validation------------------------------------------#
                if (Validator::isEmpty($data['login'])) {
                    $response['success'] = false;
                    $response['loginError'] = 'Please, fill ths field';
                } elseif (Validator::isLoginNotValid($data['login'])) {
                    $response['success'] = false;
                    $response['loginError'] = 'Login is not valid';
                } elseif ($DB->getOneByLogin($data['login'])) {
                    $response['success'] = false;
                    $response['loginError'] = 'Login already exists';
                }
                #----------------email validation-----------------------------------------#
                if (Validator::isEmpty($data['email'])) {
                    $response['success'] = false;
                    $response['emailError'] = 'Please, fill ths field';
                }  elseif (Validator::isEmailNotValid($data['email'])) {
                    $response['success'] = false;
                    $response['emailError'] = 'Email is not valid';
                }   elseif ($DB->getOneByEmail($data['email'])) {
                    $response['success'] = false;
                    $response['emailError'] = 'User with this email already exists';
                }
                #---------------password validation---------------------------------------#
                if (Validator::isEmpty($data['password'])) {
                    $response['success'] = false;
                    $response['passwordError'] = 'Please, fill ths field';
                }  elseif (Validator::isPasswordNotValid($data['password'])) {
                    $response['success'] = false;
                    $response['passwordError'] = 'Password is not valid';
                }
                #--------------passwordRepeat validation----------------------------------#
                if (Validator::isEmpty($data['passwordRepeat'])) {
                    $response['success'] = false;
                    $response['passwordRepeatError'] = 'Please, fill ths field';
                }  elseif (Validator::isPasswordsDoesNotMatch($data['password'], $data['passwordRepeat'])) {
                    $response['success'] = false;
                    $response['passwordRepeatError'] = 'Passwords does not match';
                }


                if ($response['success']) {
                    $DB->saveUser($data);
                }
                echo json_encode($response);
            }
            else {
                $data['title'] = 'Registration';
                $this->view->render('registration', $data);
            }
        }
    }
}