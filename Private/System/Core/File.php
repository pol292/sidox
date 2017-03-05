<?php

namespace Sidox\Core;

/**
 * *********************************
 *            Class File           *
 * Check and load file and folders *
 * *********************************
 * @version 05/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class File {

    /**
     * 
     * @param string $path Path to file
     * @return boolean If its file and it's exists
     */
    public static function exsits( &$path ) {
        return !is_dir( $path ) && file_exists( $path );
    }

    /**
     * 
     * @param string $path
     * @return type
     */
    public static function notExsits( &$path ) {
        return !file_exists( $path );
    }

}
