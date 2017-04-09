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
//    private static $_template;
    private static $_latte;
    private static $_layout  = NULL;
    private static $_data    = array();
    private static $_content = '';
    private static $_conf    = [];

    const PATH = PATH_APP . 'Views' . DS;

    /**
     * This method start a view
     */
    public static function init() {

        self::$_latte = new \Latte\Engine;
        self::$_latte->setTempDirectory( PATH_TEMP . 'latte' );
        self::$_conf  = System::getConf( 'page' );
        if ( !empty( self::$_conf[ 'layout' ] ) ) {
            self::$_layout = &self::$_conf[ 'layout' ];
        }
    }

    /**
     * This method set a layout of system
     * @param string $layout Layout name
     */
    public static function renderLayout( &$layout ) {
        if ( $layout || $layout === 0 ) {
            $render = &$layout;
        } elseif ( self::$_layout ) {
            $render = &self::$_layout;
        }
        if ( isset( $render ) && $render ) {
            self::$_data[ 'content' ] = &self::$_content;
            $render                   = self::PATH . 'Layouts' . DS . $render . '.latte';
            if ( file_exists( $render ) ) {
                self::$_latte->render( $render, self::$_data );
            } else {
                self::$_latte->setLoader( new \Latte\Loaders\StringLoader );

                self::$_latte->render( self::$_data[ 'content' ] );
            }
        }
    }

    /**
     * This method load View file
     * @param type $filePath The view file path
     * @param array $data Array of data
     */
    public static function render( $filePath, $data = array(), $addToLayout = FALSE ) {

        if ( $addToLayout ) {
            self::appendData( $data );
        }

        self::lattePath( $filePath );
        if ( File::exsits( $filePath ) ) {

            $content = self::$_latte->renderToString( $filePath, $data );
            
            self::$_content .= $content;
        }
    }

    public static function load( $filePath, $data = array() ) {
        self::lattePath( $filePath );
        if ( File::exsits( $filePath ) ) {
            self::$_latte->render( $filePath, $data );
        }
    }

    private static function lattePath( &$filePath ) {
        $filePath = self::PATH . $filePath;
        File::shortLoad( $filePath, '.latte' );
    }

    /**
     * This method add var to template
     * @param string $key The key of var
     * @param any $value The data of var
     */
    public static function appendVar( $key, &$value ) {
        self::$_data[ $key ] = &$value;
    }

    /**
     * This method add array of vars to template
     * @param array $vars The array of vars
     */
    public static function appendData( &$data ) {
        if ( is_array( $data ) ) {
            self::$_data = array_merge( self::$_data, $data );
        }
    }

    /**
     * This method set page title
     * @param string $title The title of page
     */
    public static function setTitle( $title, $pos = 'right', $tag = ' - ' ) {
        if ( $pos ) {
            $name = '';
            if ( !empty( self::$_conf[ 'title' ] ) ) {
                $name = &self::$_conf[ 'title' ];
            }
            $str = ($pos == 'left') ? $name . $tag . $title : $title . $tag . $name;
            self::appendVar( 'title', $str );
        } else {
            self::appendVar( 'title', $title );
        }
        self::appendVar( 'page_title', $title );
    }

    public static function redirect( $url ) {
        if ( strpos( $url, '@' ) ) {
            $url = self::link( $url );
        }
        header( "location: $url" );
    }

    public static function link( $url = '', $fullUrl = false ) {
        $mechin = System::getConf( 'settings' )[ 'mechin_name' ];
        $url    = str_replace( '@', $mechin, $url );
        return ($fullUrl ? URL_HOST : '') . URL_SHORT . $url;
    }

    public static function content() {
        self::$_latte->setLoader( new \Latte\Loaders\StringLoader );
        self::$_latte->render( self::$_data[ 'content' ] );
    }

}
