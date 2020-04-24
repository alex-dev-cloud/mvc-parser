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

    public function download(){
        $DB = new UserModel();
        $users = $DB->getAllUsers();
        $html = "<table><thead><tr><th>Id</th><th>Login</th><th>Email</th><th>Signed</th>";
        if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1) $html .= "<th>Ip</th><th>Device</th>";
        $html .= "</tr></thead><tbody>";
        foreach ($users as $user) {
            $html .= "<tr><td>$user->id</td><td>$user->login</td><td>$user->email</td><td>$user->reg_date</td>";
            if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1) $html .= "<td>$user->reg_ip</td><td>$user->reg_uagent</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
        $html .= "<style>";
        $html .= "table {width: 100%; border-collapse: collapse;}";
        $html .= "table, td, th {border: 1px solid #000;}";
        $html .= "td, th {padding: 5px;}";
        $html .= "th {text-align: center;}";
        $html .= "</style>";

        $this->pdf->SetTitle('Users');
        $this->pdf->WriteHTML($html);
        $this->pdf->Output();
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
                    try {
                        $this->mail->setFrom(SMTP_EMAIL, HOST_NAME);
                        $this->mail->addAddress($data['email'], $data['login']);
                        $this->mail->isHTML(true);
                        $this->mail->Subject = 'Code activation';
                        $this->mail->Body    = '<p>Hello, '.$data['login'].'. This is your activation code: <a href="'.URL.'?code='.md5($data['login']).'">'.md5($data['login']).'</a></p>';
                        $this->mail->send();
                    } catch(\Exception $exception) {
                        die("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
                    }
                    Session::setMessage('* Check your email to confirm registration!');
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