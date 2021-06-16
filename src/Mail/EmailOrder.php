<?php
namespace MakechTec\Nanokit\Mail;

class EmailOrder{

    public $host;
    public $userName;
    public $password;
    public $fromName;
    public $subject;
    public $addresses;
    public $bccs;
    public $ccs;
    public $template;

    public function __construct( Array $config ){        
        $this->host = $config['host'];
        $this->host = $config['userName'];
        $this->host = $config['password'];
        $this->host = $config['fromName'];
        $this->host = $config['subject'];
        $this->host = $config['addresses'];
        $this->host = $config['bccs'];
        $this->host = $config['ccs'];
        $this->host = $config['template'];
    }
    
}