<?php

namespace Sidox\Core;

class Template {
    ############################################################################
    ####                          Static Methods                            ####
    ############################################################################

    private static $_instance;

    const PATH = Path::APP . 'Views' . DS . 'Layouts' . DS;

    public static function getTemplate( $layout ) {
        return self::singleton( $layout );
    }

    private static function singleton( $layout ) {
        if ( empty( self::$_instance ) ) {
            self::$_instance = new Template( $layout );
        }
        return self::$_instance;
    }

    private static function layoutExists( $layout ) {

        $template = NULL;

        if ( $layout !== null ) {
            $template = $layout;
        } elseif ( isset( Route::$confing[ 'defualt' ][ 'layout' ] ) ) {
            $template = Route::$confing[ 'defualt' ][ 'layout' ];
        }
        $template = File::shortLoad( $template );


        if ( !is_dir( $template ) && file_exists( self::PATH . $template ) ) {
            return $template;
        } else {
            return NULL;
        }
    }

    ############################################################################
    ####                          Object Methods                            ####
    ############################################################################

    private $_layout;
    private $_vars = array();

    private function __construct( $layout ) {
        ob_start();
        $this->_layout = self::layoutExists( $layout );
    }

    public function setLayout( $layout ) {
        $this->_layout = layoutExists( $layout );
    }

    private function replaceTemplate( string $content ) {
        $openTag  = Route::$confing[ 'setting' ][ 'varOpenTag' ];
        $closeTag = Route::$confing[ 'setting' ][ 'varCloseTag' ];
        foreach ( $this->_vars as $key => $value ) {
            $content = str_replace( $openTag . $key . $closeTag, $value, $content );
        }

        return $content;
    }

    public function __set( $name, $value ) {
        $this->_vars[ $name ] = $value;
    }

    public function __get( $name ) {
        return $this->_vars[ $name ];
    }

    function __destruct() {
        $layout = self::PATH . $this->_layout;

        $content = ob_get_contents();

        if ( !is_dir( $layout ) && file_exists( $layout ) ) {
            $this->content = $content;
            $content       = file_get_contents( $layout );
        }


        $content = $this->replaceTemplate( $content );

        ob_end_clean();

        echo $content;
    }

}
