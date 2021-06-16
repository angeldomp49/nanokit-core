<?php
namespace MakechTec\Nanokit\Core\Interfaces;

use MakechTec\Nanokit\Core\Site;

interface Initializable{
    public static function init( Site &$site );
}