<?php
namespace MakechTec\Nanokit\Mail;

use MakechTec\Nanokit\Util\Logger;
use PHPMailer\PHPMailer\PHPMailer;

class Sender{
    private $defaultMailer;

    public function __construct(){
    }

    public function default(){
        $this->defaultMailer = new PHPMailer();
        $this->defaultMailer->isSMTP();
        $this->defaultMailer->SMTPAuth = true;
        $this->defaultMailer->SMTPSecure = "ssl";
        $this->defaultMailer->Port = 465;
        $this->defaultMailer->WordWrap = 50;
        $this->defaultMailer->isHTML(true);
        $this->defaultMailer->CharSet = 'UTF-8';
    }

    public function config( $order ){
            $this->defaultMailer->Host = $orden->config['host'];
            $this->defaultMailer->Username = $orden->config['userName'];
            $this->defaultMailer->Password = $orden->config['password'];
            $this->defaultMailer->setFrom($orden->config['userName'], $orden->config['fromName'] );
            $this->defaultMailer->Subject = $orden->config['subject'];
            $this->defaultMailer->Body = $this->emailTemplate( $orden->config['templatePath'], $orden->config['data'] );
    }

    public function enviarEmail( $solicitud ){
        $this->configurarEmail( $solicitud );
        if( !$this->defaultMailer->send() ){	
            throw new Exception("Error enviando el mail de respuesta", 1);
        }
    }


    public function emailTemplate( $templatePath, $params ){
        global $data;
        
        $data = $params;
        $templateString = "";
        ob_start();
        include( $templatePath );
        $templateString = ob_get_contents();
        ob_end_clean();

        return $templateString;
    }
}