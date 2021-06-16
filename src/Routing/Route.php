<?php
namespace MakechTec\Nanokit\Routing;

use \Exception;
use MakechTec\Nanokit\Url\Parser;
use MakechTec\Nanokit\Core\Request;
use MakechTec\Nanokit\Util\logger;

class Route{
    public const GET = 0;
    public const POST = 1;

    private static $routes;
    private static $currentRoute;

    private $uri;
    private $requestType;
    private $classController;
    private $methodController;
    private $parameters;
    private $request;

    public static function get( $uri, $controller ){
        $route = self::createRoute( self::GET, $uri, $controller );
        self::register( $route );
    }

    public static function post( $uri, $controller ){
        $route = self::createRoute( self::POST, $uri, $controller );
        self::register( $route );
    }

    public static function createRoute( $requestType, $uri, $controller ){
        $route = new Route();
        $route->setRequestType( $requestType );
        $route->setUri( $uri );
        $route->setClassController( $controller[0] );
        $route->setMethodController( $controller[1] );
        return $route;
    }

    public static function register( Route $route ){
        self::$routes[] = $route;
    }

    public static function currentRoute( Request $request ){

        foreach (self::$routes as $route){
            if( self::matchRequestRoute( $request, $route ) ){
                self::initCurrentRoute( $request, $route );
                return self::$currentRoute;
            }
        }

        throw new Exception( 'Route not found with uri = ' . $request->geturi() );
    }

    public static function initCurrentRoute( Request $request, Route $route ){
        self::$currentRoute = $route;
        self::$currentRoute->request = $request;
        self::$currentRoute->generateParameters();
    }

    public static function matchRequestRoute( Request $request, Route $route ){
        if( self::isBaseUri( $request->getUri() ) || self::isBaseUri( $route->getUri() ) ){
            if( self::isBaseUri( $request->getUri() ) && self::isBaseUri( $route->getUri() ) ){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return self::searchRoute( $request, $route );
        }
    }

    public static function searchRoute( Request $request, Route $route ){
        $routeUri = Parser::removeAroundSlashes( $route->getUri() );
        $requestUri = Parser::removeAroundSlashes( $request->getUri() );

        $routeRegex = Parser::createRegexFromRouteUri( $routeUri );

        $isEqual = preg_match( $routeRegex, $requestUri );
        return $isEqual;
    }


    public function generateParameters(){
        $routeSlugs = Parser::slugsFromUri( $this->getUri() );
        $paramsNames = Parser::paramsNamesFromSlugs( $routeSlugs );

        $requestSlugs = Parser::slugsFromUri( $this->request->getUri() );
        $paramsValues = array_diff( $requestSlugs, $routeSlugs );
        
        $parameters = array_combine( $paramsNames, $paramsValues );
        $this->setParameters( $parameters);
    }

    public static function isBaseUri( $uri ){
        $case1 = ( $uri == "" );
        $case2 = ( $uri == "/" );
        return ( $case1 || $case2 ) ? true : false ;
    }

    
    public function getUri(){
        return $this->uri;
    }

    public function setUri($uri){
        $this->uri = $uri;

        return $this;
    }

    public function getRequestType(){
        return $this->requestType;
    }

    public function setRequestType($requestType){
        $this->requestType = $requestType;

        return $this;
    }

    public function getClassController(){
        return $this->classController;
    }

    public function setClassController($classController){
        $this->classController = $classController;

        return $this;
    }

    public function getMethodController(){
        return $this->methodController;
    }

    public function setMethodController($methodController){
        $this->methodController = $methodController;

        return $this;
    }

    public function getParameters(){
        return $this->parameters;
    }

    public function setParameters($parameters){
        $this->parameters = $parameters;

        return $this;
    }

}