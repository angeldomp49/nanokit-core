<?php
namespace MakechTec\Nanokit\Routing;

use MakechTec\Nanokit\Routing\Route;
use MakechTec\Nanokit\Core\Site;
use MakechTec\Nanokit\Core\Interfaces\Initializable;
use MakechTec\Nanokit\Util\Logger;

class Config implements Initializable{

    public static function init( Site &$site ){
        addSettingsFile( "routes.php" );

        $currentRoute = Route::currentRoute( $site->request );
        $classController = $currentRoute->getClassController();
        $methodController = $currentRoute->getMethodController();
        $parameters = $currentRoute->getParameters();

        $instance = new $classController();
        call_user_func_array( [ $instance, $methodController ], $parameters );
    }
}