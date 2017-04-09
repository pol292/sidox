<?php

namespace Sidox\Core\Models;

/**
 * **************************************
 *              Class DB                *
 * This class create connection to DB   *
 * **************************************
 * @version 13/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class Singelton_DB {

    private static $_link;

    public static function connect() {
        return self::singelton_connection();
    }

    private static function singelton_connection() {
        if ( !self::$_link ) {
            $db          = \Sidox\Core\System::getConf( 'DATABASE' );
            self::$_link = mysqli_connect( $db[ 'HOST' ], $db[ 'USER' ], $db[ 'PASS' ], $db[ 'DB' ] );
        }
        return self::$_link;
    }

    public static function close_connection() {
        if ( self::$_link instanceof \mysqli ) {
            mysqli_close( self::$_link );
        }
    }

}
