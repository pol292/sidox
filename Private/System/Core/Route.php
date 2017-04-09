<?php

namespace Sidox\Core;

/**
 * *******************************************************************
 *                            Class Route                            *
 * This Class start running the Framework and call to the controller *
 * *******************************************************************
 * @version 05/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class Route {

    /**
     * @var Array This array save excuted url to controller & action & vars 
     */
    private static $_request = array();

    /**
     * This method init route
     * @param string $conf Main conf to use
     */
    public static function init() {

        self::cutUrl();
        self::createRouter();
        self::executeController();
    }

    /**
     * This class excute self::$request and run:
     * $controller->$action($var1,$var2...$varN);
     * @private
     * @static
     */
    private static function executeController() {

        $controller     = &self::$_request[ 'controller' ];
        $action         = &self::$_request[ 'action' ];
        $controllerFile = Controller::PATH . $controller . '.php';


        if ( File::notExsits( $controllerFile ) ) {
            self::error404( 'Controller File not found' );
        } else {
            require $controllerFile;
            if ( !class_exists( $controller ) ) {
                self::error404( 'Class not found' );
            } elseif ( !method_exists( $controller, $action ) ) {
                self::error404( 'Action not found' );
            } else {

                $controllerObj = new $controller();
                if ( !($controllerObj instanceof Controller) ) {
                    self::error404( 'This is Invalid Controller' );
                } elseif ( self::hasRequiredParameters( $controllerObj ) ) {
                    call_user_func_array( array( $controllerObj, $action ), self::$_request[ 'vars' ] );
                } else {
                    self::error404( 'Page require var' );
                }
            }
        }
    }

    private static function hasRequiredParameters( &$controller ) {
        $method = new \ReflectionMethod( $controller, self::$_request[ 'action' ] );

        return sizeof( self::$_request[ 'vars' ] ) >= $method->getNumberOfRequiredParameters();
    }

    private static function error404( $err ) {
        $errorCon = System::getConf( 'settings' )[ 'error_controller' ];
        $file = Controller::PATH . 'PageErrorController.php';
        if ( File::exsits( $file ) ) {
            require_once $file;
            if ( class_exists( $errorCon ) ) {
                $pageNotFound = new $errorCon();
                self::$_request[ 'controller' ] = $errorCon;
                $pageNotFound->Err404( [ 'error' => $err ] );
            }
        } else {
            View::redirect( './' );
        }
        die();
    }

    /**
     * This method execute Url and create cotroller & action & vars
     * @static
     * @pravite
     */
    private static function cutUrl() {
        $url = filter_input( INPUT_GET, 'url', FILTER_SANITIZE_STRING );
        if ( $url ) {
            $mechin = System::getConf( 'settings' )[ 'mechin_name' ];
            $url    = htmlentities( $url, ENT_QUOTES );

            $url = trim( $url );
            $url = trim( $url, $mechin );
            $url = trim( $url );

            $url        = preg_replace( "/$mechin+/", $mechin, $url );
            $url        = strtolower( $url );
            // next code add slash for url for explode it
            $selshCount = substr_count( $url, $mechin );
            if ( $selshCount < 2 ) {
                $add = -($selshCount - 2);
                $url .= str_repeat( $mechin, $add );
            }

            // cut $url to array in self::request
            list(self::$_request[ 'controller' ],
                    self::$_request[ 'action' ],
                    self::$_request[ 'vars' ]) = explode( $mechin, $url, 3 );
        }
    }

    /**
     * This method check if set page for check page for load
     */
    private static function createRouter() {
        if ( empty( self::$_request[ 'vars' ] ) ) {
            self::$_request[ 'vars' ] = array();
        } else {
            $mechin                   = System::getConf( 'settings' )[ 'mechin_name' ];
            self::$_request[ 'vars' ] = explode( $mechin, self::$_request[ 'vars' ] );
        }

        $conf = System::getConf( 'defualt' );
        if ( empty( self::$_request[ 'action' ] ) ) {
            self::$_request[ 'action' ] = &$conf[ 'action' ];
        }

        if ( empty( self::$_request[ 'controller' ] ) ) {
            self::$_request[ 'controller' ] = &$conf[ 'controller' ];
        }


        self::$_request[ 'controller' ] = ucfirst( self::$_request[ 'controller' ] ) . 'Controller';
        self::$_request[ 'action' ]     = ucfirst( self::$_request[ 'action' ] ) . 'Action';
    }

    public static function getController() {
        return self::$_request[ 'controller' ];
    }

    public static function getAction() {
        return self::$_request[ 'action' ];
    }

    public static function getVars() {
        return self::$_request[ 'vars' ];
    }

}
