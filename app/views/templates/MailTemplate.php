<?php


namespace app\views\templates;


class MailTemplate
{
    private $html;

    public function __construct($data)
    {
        $this->html = "<p>Hello, {$data['login']}. ";
        $this->html .= 'This is your activation code: <a href="'.URL.'?code=';
        $this->html .= urlencode($data['token']).'">'.$data['token'].'</a></p>';
    }

    public function getHTML(){
        return $this->html;
    }

    public function __toString()
    {
        return $this->html;
    }

}