<?php


namespace app\controllers;


use app\models\UserModel;
use app\views\templates\MailTemplate;
use app\views\templates\UsersTemplate;
use core\Controller;
use core\Secure;
use core\Session;
use core\Validator;

class UserController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
    }

    public function index(){

        $users = $this->model->getAllUsers();
        $data = [
            'title' => 'Users',
            'users' => $users,
        ];
        $this->view->render('users', $data);
    }

    public function download(){
        $users = $_SERVER['REQUEST_URI'] == '/user/download/activated' ? $this->model->getActivatedUsers() : $this->model->getAllUsers();
        $html = new UsersTemplate($users);

        $this->pdf->SetTitle('Users');
        $this->pdf->WriteHTML($html);
        $this->pdf->Output();
    }

    public function login(){
        if (Session::checkUser()) {
            header('Location: /');
        } else {

            if (!empty($_POST)) {

                $data = [
                    'title' => 'Registration',
                    'login' => Secure::treatData($_POST['login']),
                    'password' => Secure::treatData($_POST['password']),
                ];

                $user = $this->model->getOneByLogin($data['login']);

                $errors = [];

                if (Validator::isEmpty($data['login'])) $errors['loginError'] = 'Please, fill this field';
                if (Validator::isEmpty($data['password'])) $errors['passwordError'] = 'Please, fill this field';

                if (!count($errors) && !$user || !count($errors) && !password_verify($data['password'], $user->password)) {
                    $errors['loginError'] = 'Wrong login or password';
                    $errors['passwordError'] = 'Wrong login or password';
                }

                if (!count($errors)) {
                    Session::setUser($user);
                }

                $response = [
                    'success' => !count($errors),
                    'errors' => $errors,
                ];

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

                $data = [
                    'title' => 'Registration',
                    'login' => Secure::treatData($_POST['login']),
                    'email' => Secure::treatData($_POST['email']),
                    'password' => Secure::treatData($_POST['password']),
                    'passwordRepeat' => Secure::treatData($_POST['passwordRepeat']),
                ];

                $data['token'] = password_hash($data['login'], PASSWORD_DEFAULT) . time();

                #============ USER DATA VALIDATION =======================================#

                $errors = [];

                #---------------login validation------------------------------------------#
                if (Validator::isEmpty($data['login'])) {
                    $errors['loginError'] = 'Please, fill ths field';
                } elseif (Validator::isLoginNotValid($data['login'])) {
                    $errors['loginError'] = 'Login is not valid';
                } elseif ($this->model->getOneByLogin($data['login'])) {
                    $errors['loginError'] = 'Login already exists';
                }
                #----------------email validation-----------------------------------------#
                if (Validator::isEmpty($data['email'])) {
                    $errors['emailError'] = 'Please, fill ths field';
                }  elseif (Validator::isEmailNotValid($data['email'])) {
                    $errors['emailError'] = 'Email is not valid';
                }  elseif ($this->model->getOneByEmail($data['email'])) {
                    $errors['emailError'] = 'User with this email already exists';
                }
                #---------------password validation---------------------------------------#
                if (Validator::isEmpty($data['password'])) {
                    $errors['passwordError'] = 'Please, fill ths field';
                }  elseif (Validator::isPasswordNotValid($data['password'])) {
                    $errors['passwordError'] = 'Password is not valid';
                }
                #--------------passwordRepeat validation----------------------------------#
                if (Validator::isEmpty($data['passwordRepeat'])) {
                    $errors['passwordRepeatError'] = 'Please, fill ths field';
                }  elseif (Validator::isPasswordsDoesNotMatch($data['password'], $data['passwordRepeat'])) {
                    $errors['passwordRepeatError'] = 'Passwords does not match';
                }

                if (!count($errors)) {
                    $this->model->saveUser($data);
                    try {
                        $this->mail->setFrom(SMTP_EMAIL, HOST_NAME);
                        $this->mail->addAddress($data['email'], $data['login']);
                        $this->mail->isHTML(true);
                        $this->mail->Subject = 'Code activation';
                        $mail =  new MailTemplate($data);
                        $this->mail->Body = $mail->getHTML();
                        $this->mail->send();
                    } catch(\Exception $exception) {
                        die("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
                    }
                    Session::setMessage('* Check your email to confirm registration!');
                }

                $response = [
                    'success' => !count($errors),
                    'errors' => $errors,
                ];

                echo json_encode($response);
            }
            else {
                $data['title'] = 'Registration';
                $this->view->render('registration', $data);
            }
        }
    }
}