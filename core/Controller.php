<?php


namespace core;


use Mpdf\Mpdf;
use PHPMailer\PHPMailer\PHPMailer;

class Controller
{
    protected $view;
    protected $mail;
    protected $pdf;

    public function __construct()
    {
        $this->view = new View();
        $this->mail = new PHPMailer();
        $this->pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L',
        ]);

        $this->mail->isSMTP();
        $this->mail->Host       = SMTP_HOST;
        $this->mail->SMTPAuth   = SMTP_AUTH;
        $this->mail->Username   = SMTP_USERNAME;
        $this->mail->Password   = SMTP_PASSWORD;
        $this->mail->SMTPSecure = SMTP_SECURE;
        $this->mail->Port       = SMTP_PORT;

    }
}