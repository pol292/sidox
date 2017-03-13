<?php

namespace Sidox\Core;
/**
 * *****************************************
 *               Class Template            *
 * This class load main template of system *
 * *****************************************
 * @version 13/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class Template {
    ############################################################################
    ####                          Static Methods                            ####
    ############################################################################

    /**
     * @var Template The template instance 
     */
    private static $_instance;

    const PATH = PATH_APP . 'Views' . DS . 'Layouts' . DS;

    /**
     * This method get first template
     * @param typ $layout The layout name
     * @return Template Return template instance
     */
    public static function getTemplate( $layout ) {
        return self::singleton( $layout );
    }

    /**
     * This method get first template
     * @param typ $layout The layout name
     * @return Template Return template instance
     * @private
     */
    private static function singleton( $layout ) {
        if ( empty( self::$_instance ) ) {
            self::$_instance = new Template( $layout );
        }
        return self::$_instance;
    }

    /**
     * This method check if layout exists
     * @param string $layout The layout for check
     * @return string|null Return template if exsits or null
     */
    private static function layoutExists( $layout ) {

        $template = NULL;

        if ( $layout !== null ) {
            $template = $layout;
        } elseif ( isset( System::$confing[ 'defualt' ][ 'layout' ] ) ) {
            $template = System::$confing[ 'defualt' ][ 'layout' ];
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

    /**
     * @var string The layout to use
     */
    private $_layout;
    /**
     * @var array The var of template
     */
    private $_vars = array();

    /**
     * This method init the template
     * @param string $layout The layout name
     */
    private function __construct( $layout ) {
        ob_start();
        $this->_layout = self::layoutExists( $layout );
    }

    /**
     * This method set other layout
     * @param string $layout The layout to set
     */
    public function setLayout( $layout ) {
        $this->_layout = layoutExists( $layout );
    }

    /**
     * This method merge template with page
     * @param string $content The content of page
     * @return string New content
     */
    private function replaceTemplate( $content ) {
        $openTag  = System::$confing[ 'setting' ][ 'varOpenTag' ];
        $closeTag = System::$confing[ 'setting' ][ 'varCloseTag' ];
        foreach ( $this->_vars as $key => $value ) {
            $content = str_replace( $openTag . $key . $closeTag, $value, $content );
        }

        return $content;
    }

    /**
     * This method set new var for template
     * @param string $name The name of var
     * @param any $value The value of var
     */
    public function __set( $name, $value ) {
        $this->_vars[ $name ] = $value;
    }

    /**
     * This method return the var
     * @param string $name The name of var
     * @return any The value of var
     */
    public function __get( $name ) {
        return $this->_vars[ $name ];
    }

    /**
     * This method merge content of page with layout
     */
    function __destruct() {
        $layout = self::PATH . $this->_layout;

        $content = ob_get_contents();

        if ( !is_dir( $layout ) && file_exists( $layout ) ) {
            $this->content = $content;
            ob_end_clean();
            include $layout;
            $content = ob_get_contents();
//            $content       = file_get_contents( $layout );
        }


        $content = $this->replaceTemplate( $content );

        ob_end_clean();

        echo $content;
        DB::close_connection();
    }

}
