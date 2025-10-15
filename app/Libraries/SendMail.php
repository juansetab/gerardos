<?php
namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
require APPPATH."Thirdparty/phpmailer/Exception.php";
require APPPATH."Thirdparty/phpmailer/PHPMailer.php";
require APPPATH."Thirdparty/phpmailer/SMTP.php";

class SendMail
{
    private $remitente = "";
    private $password = "";
    private $alias = "";

    public function __construct()
    {
        $this->remitente = "juanmanuel.trinidad@correo.setab.gob.mx";
        $this->password = "iniciarSesion*26";
        $this->alias = "Portal de trámites de la Secretaría de Educación";
    }

    public function send($destinatario, $asunto, $html)
    {
        $mail = new PHPMailer;
        $mail->isSMTP(); 
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "smtp-mail.outlook.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        //$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 587; // TLS only
        $mail->SMTPSecure = 'tls'; // ssl is deprecated
        $mail->SMTPAuth = true;
        $mail->Username = $this->remitente;
        $mail->Password = $this->password ;
        $mail->setFrom($this->remitente, mb_convert_encoding("Portal de tramites     - SETAB", 'ISO-8859-1', 'UTF-8'));
        $mail->addAddress($destinatario, $this->alias);
        $mail->Subject =  mb_convert_encoding($asunto, 'ISO-8859-1', 'UTF-8');
        $mail->isHTML(true);
        $mail->msgHTML(mb_convert_encoding($html, 'ISO-8859-1', 'UTF-8')); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        //$mail->AltBody = 'HTML messaging not supported';
        //$mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
        if(!$mail->send()){
            return array("status" => 0, "msg" => $mail->ErrorInfo);
        }else{
            return array("status" => 1, "msg" => "Mensaje enviado!");
        }
    }

}

