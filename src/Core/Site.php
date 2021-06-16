<?php
namespace MakechTec\Nanokit\Core;

use MakechTec\Nanokit\Core\Request;

class Site{
    public $request;
    public $lang;
    private $modules;

    public function __construct( $modules ){
        $this->request = new Request();
        $this->lang = null;
        $this->modules = $modules;
    }

    public function getModules(){
        return $this->modules;
    }
}