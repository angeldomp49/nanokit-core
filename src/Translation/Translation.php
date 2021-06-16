<?php
namespace MakechTec\Nanokit\Translation;

use \SplFileObject;
use MakechTec\Nanokit\Util\Logger;
use MakechTec\Nanokit\Core\Kernel;

class Translation{
    public static $lang;
    public static $isActive = false;

    public static function translate( $message ){
        if( !self::$isActive ){
            echo( $message );
            return;
        }

        $currentLang = self::$lang;
        $langFileName = "lang/" . $currentLang . ".json";
        $langFileName = rightPath( $langFileName );
    
        $stringsArray = self::arrayFromJsonFile( $langFileName );
        if( empty( $stringsArray ) ){
            echo( $message );
        }
        else{
            self::translatedString( $message, $stringsArray );
        }
    }

    public static function arrayFromJsonFile( $fileName ){
        if( !file_exists( $fileName ) ){
            Logger::err( "Language file not found for: " . $fileName );
            return [];
        }
        else{
            $langFile = new SplFileObject( $fileName );
            $langFileContent = $langFile->fread( $langFile->getSize() );
            $langArr = json_decode( $langFileContent, true ); 
            return $langArr;
        }
    }

    public static function translatedString( $message, $stringsArray ){
        foreach ($stringsArray as $item) {
            foreach ($item as $key => $value) {
                if( $message == $key ){
                    echo( $value );
                    return;
                }
            }
        }

        echo( $message );
    }
}