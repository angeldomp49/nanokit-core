<?php
namespace MakechTec\Nanokit\Translation;

use MakechTec\Nanokit\Core\Site;
use MakechTec\Nanokit\Url\Parser;
use MakechTec\Nanokit\Util\Logger;
use MakechTec\Nanokit\Translation\Translation;
use MakechTec\Nanokit\Core\Interfaces\Initializable;

class Config implements Initializable{

    public static function init( Site &$site ){
        $slugs = Parser::slugsFromUri( $site->request->getUri() );
        $first = $slugs[0];

        if( self::isLang( $first ) ){
            $site->lang = $first;
            Translation::$lang = $first;
            $newUri = Parser::removeFirstSlug( $site->request->getUri() );
            $site->request->setUri( $newUri );
        }
        else{
            $site->lang = DEFAULT_LANGUAGE;
            Translation::$lang = DEFAULT_LANGUAGE;
        }

        Translation::$isActive = true;
    }

    public static function isLang( $slug ){
        $langsAllowed = include( rightPath( 'app/translations.php' ) );

        foreach ($langsAllowed as $allow ) {
            if( $allow == $slug ){
                return true;
            }
        }
        return false;
    }
}