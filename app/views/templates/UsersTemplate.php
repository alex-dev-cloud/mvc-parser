<?php


namespace app\views\templates;


use core\Session;

class UsersTemplate
{
    private $html;

    public function __construct($users)
    {
        $this->html = '<table><thead><tr><th>Id</th><th>Login</th><th>Email</th><th>Signed</th>';
        if(Session::checkUser() && $_SESSION['user']->role == 1) $this->html .= '<th>Ip</th><th>Device</th>';
        $this->html .= '</tr></thead><tbody>';
        foreach ($users as $user) {
            $this->html .= "<tr><td>$user->id</td><td>$user->login</td><td>$user->email</td><td>$user->reg_date</td>";
            if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1) $this->html .= "<td>$user->reg_ip</td><td>$user->reg_uagent</td>";
            $this->html .= '</tr>';
        }

        $this->html .= '</tbody></table>';
        $this->html .= '<style>';
        $this->html .= 'table {width: 100%; border-collapse: collapse;}';
        $this->html .= 'table, td, th {border: 1px solid #000;}';
        $this->html .= 'td, th {padding: 5px;}';
        $this->html .= 'th {text-align: center;}';
        $this->html .= '</style>';
    }

    public function getHTML(){
        return $this->html;
    }

    public function __toString()
    {
        return $this->html;
    }
}