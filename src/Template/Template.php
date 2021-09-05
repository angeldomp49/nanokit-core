<?php
namespace MakechTec\Nanokit\Template;

use \Exception;

class Template{

    private $data;
    private $content;

    public function __construct( $filePath = "", $templateData = [] ){

        $this->data = $templateData;

        if(!file_exists($filePath)){
            throw new Exception("Error getting file template: " . $filePath);
        }

        extract($this->data);

        ob_start();
        include( $filePath );
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    public function getContent(){
        return $this->content;
    }
}