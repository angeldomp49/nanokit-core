<?php
namespace MakechTec\Nanokit\Url;
use MakechTec\Nanokit\Util\H;

class Parser{
    public const FROM_ROOT_DIRECTORY_PROJECT = 'vendor/makechtec/nanokit/Url';

    public const SLASH_REGEX = '/\//';
    public const SLASH = '/';

    public const ANTI_SLASH_REGEX = '/\\\\/';
    public const ANTI_SLASH = '\\';

    public const CURLY_BRACKET_OPEN = '{';
    public const CURLY_BRACKET_CLOSE = '}';
    public const CURLY_BRACKETS_REGEX = '/\{.*\}/';

    public const ROUTE_PARAM_NAME_REGEX = '/\{(.*?)\}/';

    public const ANY_CHAR_ANY_TIMES = '(.*)';
    public const SLASH_SCAPED = '\/';

    public static function paramsNamesFromSlugs( $slugs ){
        $paramsNamesWithCurlyBrackets = preg_grep( self::CURLY_BRACKETS_REGEX, $slugs );
        $paramsNames = [];

        foreach ($paramsNamesWithCurlyBrackets as $name ) {
            $paramsNames[] = self::removeAroundCurlyBrackets( $name );
        }

        return $paramsNames;
    }

    public static function slugsFromUri( $uri ){
        $result = [];
        
        $uri = self::removeAroundSlashes( $uri );

        while( strpos( $uri, self::SLASH ) ){

            $segments   = self::divideString( $uri, self::SLASH );
            $slugToSave = $segments['first'];
            $uri       = $segments['second'];
            array_push( $result, $slugToSave );
        }

        array_push( $result, $uri );

        return $result;
    }
    
    public static function rootPath(){
        $pathFromDisk    = __DIR__;
        $pathFromRootDirectoryProjectSameSlashes = self::equalSlashes( $pathFromDisk, FROM_ROOT_DIRECTORY_PROJECT);
    
        return str_replace( $pathFromRootDirectoryProjectSameSlashes, "", $pathFromDisk  );
    }

    public static function equalSlashes( $reference = "", $target = "" ){

        if( preg_match( self::SLASH_REGEX, $reference ) ){
            return preg_replace( self::ANTI_SLASH_REGEX, self::SLASH, $target );
        }
        else if ( preg_match( self::ANTI_SLASH_REGEX, $reference ) ){
            return preg_replace( self::SLASH_REGEX, self::ANTI_SLASH, $target );
        }
    }

    public static function removeSlugOfUri( $uri, $slug ){
        $uriSlugs = self::slugsFromUri( $uri );
        $arrSlug = [ self::removeAroundSlashes( $slug ) ];

        $uriWithoutSlug = array_diff( $uriSlugs, $arrSlug );
        return self::uriFromSlugs( $uriWithoutSlug );
    }

    public static function uriFromSlugs( $slugs ){
        $uri = '';

        foreach ($slugs as $slug) {
            $uri .= $slug . self::SLASH;
        }

        return self::removeAroundSlashes( $uri );
    }
    
    public static function createRegexFromRouteUri( $routeUri ){
        $anyValue = preg_replace( self::ROUTE_PARAM_NAME_REGEX, self::ANY_CHAR_ANY_TIMES, $routeUri );
        $anyValueAndScapedSlashes = preg_replace( self::SLASH_REGEX, self::SLASH_SCAPED, $anyValue );
        $routeUriRegex = self::SLASH . $anyValueAndScapedSlashes . self::SLASH;

        if( $routeUriRegex == "/\//" ){
            
        }
        return $routeUriRegex;
    }

    public static function removeAroundSlashes( $str ){
        $newStr = "";
        $newStr = self::removeAroundChars( $str, self::SLASH, self::SLASH );
        return $newStr;
    }

    public static function removeAroundCurlyBrackets( $str ){
        $newStr = "";
        $newStr = self::removeAroundChars( $str, self::CURLY_BRACKET_OPEN, self::CURLY_BRACKET_CLOSE );
        return $newStr;
    }

    public static function removeAroundChars( $str, $startChar, $endChar ){
        $newStr = self::removeStartChar( $str ,$startChar );
        $newStr = self::removeEndChar( $newStr, $endChar );
        return $newStr;
    }

    public static function removeStartChar( $str, $firstChar ){

        $regex = self::regexStartChar( $firstChar );

        if( preg_match_all( $regex, $str ) ){
            return self::removeFirst( $str );
        }
        else{
            return $str;
        }
    }

    public static function removeEndChar( $str, $endChar ){

        $regex = self::regexEndChar( $endChar );

        if( preg_match_all( $regex, $str ) ){
            return self::removeLast( $str );
        }
        else{
            return $str;
        }
    }

    public static function regexStartChar( $character ){
        if ( ctype_alpha( $character ) ) {
            $regex = "/^" . $character . "/";
        } 
        else {
            $regex = "/^\\" . $character . "/";
        }

        return $regex;
        
    }

    public static function regexEndChar( $character ){
        if ( ctype_alpha( $character ) ) {
            $regex = "/" . $character . "$/";
        } 
        else {
            $regex = "/\\" . $character . "$/";
        }

        return $regex;
        
    }

    public static function removeFirst( $str ){
        return substr( $str, 1, strlen( $str ) );
    }

    public static function removeLast( $str ){
        return substr( $str, 0, strlen( $str ) - 1 );
    }

    public static function divideString( $str, $divider ){
        $firstPart   = strstr( $str, $divider, true );
        $secondPart     = strstr( $str, $divider );
        $secondPart  = substr( $secondPart, 1, strlen( $secondPart ) );

        return [
            "first"  => $firstPart,
            "second" => $secondPart
        ];
    }

    public static function removeFirstSlug( $uri ){
        $slugs = self::slugsFromUri( $uri );
        unset( $slugs[0] );
        $newUri = self::uriFromSlugs( $slugs );
        return $newUri;
    }

    public static function removeLastSlug( $uri ){
        $slugs = self::slugsFromUri( $uri );
        $i = count( $slugs ) - 1;
        unset( $slugs[$i] );
        $newUri = self::uriFromSlugs( $slugs );
        return $newUri;
    }

}