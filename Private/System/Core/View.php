<?php

namespace Sidox\Core;

/**
 * Description of View
 *
 * @author Pol
 */
class View {
  
    private static $_template;

    const PATH = Path::APP . 'Views' . DS;

    public static function init() {
        $template = NULL;

        if ( isset( Route::$confing[ 'defualt' ][ 'layout' ] ) ) {
            $template = Route::$confing[ 'defualt' ][ 'layout' ];
        }

        View::$_template = Template::getTemplate( $template );
    }

    public static function setLayout( $layout ) {
        View::$_template->setLayout( $template );
    }

    public static function load( $filePath, array $data = array() ) {

        extract( $data );
        self::addVars( $data );

        $filePath = File::shortLoad( $filePath );

        $filePath = str_replace( "::", DS, $filePath );
        $filePath = self::PATH . $filePath;

        if ( !is_dir( $filePath ) && file_exists( $filePath ) ) {
            require_once($filePath);
        }
    }

    public static function addVar( string $key, $value ) {
        self::$_template->$key = $value;
    }

    public static function setTitle( string $title ) {
        self::addVar( 'title', $title );
    }

    public static function addVars( array $vars ) {
        if ( is_array( $vars ) ) {
            foreach ( $vars as $key => $value ) {
                self::addVar( $key, $value );
            }
        }
    }

}
