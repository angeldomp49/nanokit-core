<?php
namespace MakechTec\Nanokit\Template;

class Template{

    private $data;
    private $content;

    public function __construct( $filePath = "", $templateData = [] ){

        $this->data = $template_data;
        global $data;
        $data = $this->data;

        if(!file_exists($filePath)){
            throw new Exception("Error getting file template: " . $filePath);
        }

        ob_start();
        include( $filePath );
        $this->content( ob_get_contents() );
        ob_end_clean();
    }

    public function getContent(){
        return $this->content;
    }
}