<?php

Load::lib('PHPMailer//PHPMailerAutoload');

class Correo {
    protected $mail = NULL;
    
    public function enviarSolicitud($nombre,$email,$asunto,$mensaje) {
        $config = Config::read('email');
        
        $this->mail = new PHPMailer();
        
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Debugoutput = 'html';
        $this->mail->SMTPAuth = $config['smtpauth'];
        $this->mail->SMTPSecure = $config['smtpsecure'];
        $this->mail->Host = $config['host'];
        $this->mail->Port = $config['port'];
        $this->mail->Username = $config['username'];
        $this->mail->Password = $config['password'];
        $this->mail->SetFrom($email, $nombre);
        $this->mail->addReplyTo($email, $nombre);
        $this->mail->addAddress('anasmutag@gmail.com');
        $this->mail->Subject = $asunto;
        $this->mail->msgHTML($mensaje);

        if (!$this->mail->send()) {
            return false;
        } else {
            return true;
        }
    }
}
