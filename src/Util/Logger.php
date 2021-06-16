<?php
namespace MakechTec\Nanokit\Util;

class Logger {
    public static function log( $message ){
        ?>
            <p><?php echo( $message ); ?></p>
        <?php
    }
    public static function logDump( $message ){
        ?>
            <p><?php var_dump( $message ); ?></p>
        <?php
    }

    public static function err( $message ){
        trigger_error( $message );
    }

    public static function logBool( $statement ){
        ?>
        <p><?php echo( ( $statement ) ? "true" : "false" ); ?></p>
        <?php
    }
}