<?php

namespace Sidox\Core;

/**
 * *****************************************
 *                Class View               *
 * This class mangemant the view of system *
 * *****************************************
 * @version 06/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class View {
  
    /**
     * @var Template The template of system
     */
    private static $_template;

    const PATH = Path::APP . 'Views' . DS;

    /**
     * This method start a view
     */
    public static function init() {
        $template = NULL;

        if ( isset( Route::$confing[ 'defualt' ][ 'layout' ] ) ) {
            $template = Route::$confing[ 'defualt' ][ 'layout' ];
        }

        View::$_template = Template::getTemplate( $template );
    }

    /**
     * This method set a layout of system
     * @param string $layout Layout name
     */
    public static function setLayout( $layout ) {
        View::$_template->setLayout( $template );
    }

    /**
     * This method load View file
     * @param type $filePath The view file path
     * @param array $data Array of data
     */
    public static function load( $filePath, $data = array() ) {

        extract( $data );
        self::addVars( $data );

        $filePath = File::shortLoad( $filePath );

        $filePath = str_replace( "::", DS, $filePath );
        $filePath = self::PATH . $filePath;

        if ( !is_dir( $filePath ) && file_exists( $filePath ) ) {
            require_once($filePath);
        }
    }

    /**
     * This method add var to template
     * @param string $key The key of var
     * @param any $value The data of var
     */
    public static function addVar( $key, $value ) {
        self::$_template->$key = $value;
    }

    /**
     * This method add array of vars to template
     * @param array $vars The array of vars
     */
    public static function addVars( $vars ) {
        if ( is_array( $vars ) ) {
            foreach ( $vars as $key => $value ) {
                self::addVar( $key, $value );
            }
        }
    }

    
    /**
     * This method set page title
     * @param string $title The title of page
     */
    public static function setTitle( $title ) {
        self::addVar( 'title', $title );
    }

    
}
