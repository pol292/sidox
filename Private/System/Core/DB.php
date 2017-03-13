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
class DB {

    private static $_link;

    public static function connect() {
        return self::singelton_connection();
    }

    private static function singelton_connection() {
        if ( self::$_link ) {
            return self::$_link;
        }
        $db          = System::$confing[ 'DATABASE' ];
        self::$_link = mysqli_connect( $db[ 'HOST' ], $db[ 'USER' ], $db[ 'PASS' ], $db[ 'DB' ] );
    }
    
    public static function close_connection(){
        mysqli_close(self::$_link);
    }
}
