<?php

namespace Sidox\Core;

/**
 * **************************************
 *             Class System             *
 * This class contin the system conf &  *
 *          bootstrap of system         *
 * **************************************
 * @version 13/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class System {

    /**
     * @var Array This is the config of system 
     */
    private static $_confing = array();

    /**
     * This method start running the system
     * @param string $conf Main conf to use
     */
    public static function init( $conf = 'main' ) {
// reqiure System conf
        $sysConf = PATH_SYS . 'Confings' . DS . 'core.conf.php';
        if ( File::exsits( $sysConf ) ) {
            self::$_confing = require_once($sysConf);
        }

        $conf = PATH_APP . 'Confings' . DS . $conf . '.conf.php';
        if ( File::exsits( $conf ) ) {
            $conf = include($conf);
            self::array_merge_recursive( self::$_confing, $conf );
        }
        session_name(self::$_confing[ 'settings' ][ 'session_name' ]);
        session_start();
        session_regenerate_id();

        date_default_timezone_set(self::$_confing[ 'settings' ][ 'time_zone' ]);
        self::createAlias();
        Route::init();
    }

    private static function array_merge_recursive( &$arr1, &$arr2 ) {
        foreach ( $arr2 as $key => $value ) {
            if ( key_exists( $key, $arr1 ) && is_array( $arr2[ $key ] ) ) {
                self::array_merge_recursive( $arr1[ $key ], $arr2[ $key ] );
            } else {
                $arr1[ $key ] = $arr2[ $key ];
            }
        }
    }

    /**
     * This method create alias to main class
     */
    private static function createAlias() {
        foreach ( self::$_confing[ 'alias' ] as $namespace => $class ) {
            class_alias( $namespace, $class );
        }
    }

    public static function getConf( $key = FALSE ) {
        if ( key_exists( $key, self::$_confing ) ) {
            return self::$_confing[ $key ];
        }
        return self::$_confing;
    }

}
