<?php


namespace app\controllers;


use app\models\UserModel;
use core\Controller;
use core\Secure;
use core\Session;
use core\Validator;

class UserController extends Controller
{
    private $MODEL;

    public function __construct()
    {
        parent::__construct();
        $this->MODEL = new UserModel();
    }

    public function index(){

        $users = $this->MODEL->getAllUsers();
        $data = [
            'title' => 'Users',
            'users' => $users,
        ];
        $this->view->render('users', $data);
    }

    public function download(){
        $users = $_SERVER['REQUEST_URI'] == '/user/download/activated' ? $this->MODEL->getActivatedUsers() : $this->MODEL->getAllUsers();

        $html = '<table><thead><tr><th>Id</th><th>Login</th><th>Email</th><th>Signed</th>';
        if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1) $html .= '<th>Ip</th><th>Device</th>';
        $html .= '</tr></thead><tbody>';
        foreach ($users as $user) {
            $html .= "<tr><td>$user->id</td><td>$user->login</td><td>$user->email</td><td>$user->reg_date</td>";
            if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1) $html .= "<td>$user->reg_ip</td><td>$user->reg_uagent</td>";
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<style>';
        $html .= 'table {width: 100%; border-collapse: collapse;}';
        $html .= 'table, td, th {border: 1px solid #000;}';
        $html .= 'td, th {padding: 5px;}';
        $html .= 'th {text-align: center;}';
        $html .= '</style>';

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

                $user = $this->MODEL->getOneByLogin($data['login']);

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
                } elseif ($this->MODEL->getOneByLogin($data['login'])) {
                    $errors['loginError'] = 'Login already exists';
                }
                #----------------email validation-----------------------------------------#
                if (Validator::isEmpty($data['email'])) {
                    $errors['emailError'] = 'Please, fill ths field';
                }  elseif (Validator::isEmailNotValid($data['email'])) {
                    $errors['emailError'] = 'Email is not valid';
                }  elseif ($this->MODEL->getOneByEmail($data['email'])) {
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
                    $this->MODEL->saveUser($data);
                    try {
                        $this->mail->setFrom(SMTP_EMAIL, HOST_NAME);
                        $this->mail->addAddress($data['email'], $data['login']);
                        $this->mail->isHTML(true);
                        $this->mail->Subject = 'Code activation';
                        $this->mail->Body    = '<p>Hello, '.$data['login'].'. This is your activation code: <a href="'.URL.'?code='.urlencode($data['token']).'">'.$data['token'].'</a></p>';
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