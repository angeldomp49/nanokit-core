<?php
namespace MakechTec\Nanokit\Util;

use MakechTec\Nanokit\Core\Site;
use MakechTec\Nanokit\Core\Interfaces\Initializable;
use Illuminate\Database\Capsule\Manager as DB;

class Config implements Initializable{

    public static function init( Site &$site ){
        $settingsName = "vendor/makechtec/nanokit/Util/functions.php";
        $settingsFile = rightPath($settingsName);
    
        if(!file_exists($settingsFile)){
            throw new Exception("must have $filename file", 1);
        }
        include_once($settingsFile);
    }
}