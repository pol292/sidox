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

    /**
     * This method shor load view files
     * @param type $fileName The path to load
     * @return string The file name to load
     */
    public static function shortLoad( &$fileName ) {
        $fileName = str_replace( "::", DS, $fileName );
        //TODO: check extenstion
        if ( !strpos ( $fileName , '.') ) {
            $fileName .= '.php';
        }
        return $fileName;
    }
}
