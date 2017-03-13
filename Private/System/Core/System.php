<?php

namespace Sidox\Core;

/**
 * **************************************
 *              Class Model             *
 * This class for load and create model *
 * **************************************
 * @version 13/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class System {

    /**
     * @var Array This is the config of system 
     */
    public static $confing = array();

    
    /**
     * This method start running the system
     * @param string $conf Main conf to use
     */
    public static function init( $conf = 'main' ) {
        session_start();
        // reqiure System conf
        $sysConf = PATH_SYS . 'Confings' . DS . 'core.conf.php';
        if ( File::exsits( $sysConf ) ) {
            self::$confing = require_once($sysConf);
        }

        $conf = PATH_APP . 'Confings' . DS . $conf . '.conf.php';
        if ( File::exsits( $conf ) ) {
            self::$confing = array_merge( self::$confing, include_once($conf) );
        }
        self::createAlias();
        Route::init();
    }

    /**
     * This method create alias to main class
     */
    private static function createAlias() {
        foreach ( self::$confing[ 'alias' ] as $namespace => $class ) {
            class_alias( $namespace, $class );
        }
    }

}
