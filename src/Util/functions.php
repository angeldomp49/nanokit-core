<?php
use MakechTec\Nanokit\Url\Parser;
use MakechTec\Nanokit\Util\Logger;
use MakechTec\Nanokit\Translation\Translation;

function view( $name, $params ){
    extract( $params );
    include( rightPath( 'src/Views/' . $name . '.php' ) );
}

function rightPath( $resource = "" ){
    $resourceRightSlashes = Parser::equalSlashes( Parser::rootPath(), $resource );
    return Parser::rootPath() . $resourceRightSlashes;
}

function _t( $message ){
    Translation::translate( $message );
}

function addSettingsFile( $filename ){
    $settingsName = "app/" . $filename;
    $settingsFile = rightPath($settingsName);

    if(!file_exists($settingsFile)){
        throw new Exception("must have $filename file", 1);
    }
    include_once($settingsFile);
}