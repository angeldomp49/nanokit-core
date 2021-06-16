<?php
namespace MakechTec\Nanokit\Mail;

use MakechTec\Nanokit\Util\Logger;
use MakechTec\Nanokit\Mail\EmailOrder;

use PHPMailer\PHPMailer\PHPMailer;

class Sender extends PHPMailer{

    public function __construct( EmailOrder $order = NULL, $exceptions = false ){
        if( ! (NULL == $order) ){
            $this->default();
            $this->config( $order );
        }
        parent::__construct($exceptions);
    }

    public function default(){
        $this->isSMTP();
        $this->SMTPAuth = true;
        $this->SMTPSecure = "ssl";
        $this->Port = 465;
        $this->WordWrap = 50;
        $this->isHTML(true);
        $this->CharSet = 'UTF-8';
    }

    public function config( EmailOrder $order ){
            $this->defaultMailer->Host = $order->host;
            $this->defaultMailer->Username = $order->userName;
            $this->defaultMailer->Password = $order->password;
            $this->defaultMailer->setFrom($order->userName, $order->fromName );
            $this->defaultMailer->Subject = $order->subject;
            $this->defaultMailer->Body = $order->template->getContent;

            $this->addReceivers( $order->addresses, $order->bccs, $order->ccs );
    }

    public function addReceivers( $addresses, $bccs, $ccs ){
        foreach ($addresses as $address) {
            $this->AddAddress( $address );
        }

        foreach ($bccs as $address) {
            $this->AddBCC( $address );
        }

        foreach ($ccs as $address) {
            $this->AddCC( $address );
        }
    }

    public function send(){
        if( !$this->send() ){	
            throw new Exception("Error enviando el mail de respuesta", 1);
        }
    }
}