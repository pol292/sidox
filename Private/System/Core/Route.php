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
     * @var Array This is the config of system 
     */
    public static $confing = array();

    /**
     * @var Array This array save excuted url to controller & action & vars 
     */
    private static $_request = array();

    /**
     * This method start running the system
     * @param string $conf Main conf to use
     */
    public static function init( $conf = 'main' ) {
        // reqiure System conf
        $sysConf = Path::CORE . '..' . DS . 'Confings' . DS . 'core.conf.php';
        if ( File::exsits( $sysConf ) ) {
            self::$confing = require_once($sysConf);
        }

        $conf = Path::APP . 'Confings' . DS . $conf . '.conf.php';
        if ( File::exsits( $conf ) ) {
            self::$confing = array_merge( self::$confing, include_once($conf) );
        }


        self::cutUrl();
        self::createRouter();
        self::createAlias();
        self::executeController();
    }

    /**
     * This class excute self::$request and run:
     * $controller->$action($var1,$var2...$varN);
     * @private
     * @static
     */
    private static function executeController() {

        $controller     = self::$_request[ 'controller' ];
        $action         = self::$_request[ 'action' ];
        $controllerFile = Controller::PATH . $controller . '.php';


        if ( File::notExsits( $controllerFile ) ) {
            self::executePage404( 'Controller File not found' );
        } else {
            require $controllerFile;
            if ( !class_exists( $controller ) ) {
                self::executePage404( 'Class not found' );
            } elseif ( !method_exists( $controller, $action ) ) {
                self::executePage404( 'Action not found' );
            } else {

                $controller = new $controller();
                if ( !($controller instanceof Controller) ) {
                    self::executePage404( 'This is Invalid Controller' );
                } elseif ( self::$_request[ 'vars' ] === NULL ) {
                    $data = $controller->self::$action();
                } elseif ( self::hasRequiredParameters( $controller ) ) {
                    $data = call_user_func_array( array( $controller, $action ), self::$_request[ 'vars' ] );
                } else {
                    self::executePage404( 'Page require var' );
                }
            }
        }
    }

    private static function hasRequiredParameters( &$controller ) {
        $method = new \ReflectionMethod( $controller, self::$_request[ 'action' ] );

        return sizeof( self::$_request[ 'vars' ] ) >= $method->getNumberOfRequiredParameters();
    }

    private static function executePage404( $err ) {
        echo '404 error: <br>' . $err;
    }

    /**
     * This method execute Url and create cotroller & action & vars
     * @static
     * @pravite
     */
    private static function cutUrl() {
        if ( isset( $_GET[ 'url' ] ) ) {
            //TODO: Check hack url
            $url = $_GET[ 'url' ];
            $url = htmlspecialchars( $url, ENT_QUOTES );
            $url = trim( $url, "/" );
            $url = preg_replace( '/\/+/', '/', $url );

            // next code add slash for url for explode it
            $selshCount = substr_count( $url, '/' );
            if ( $selshCount < 2 ) {
                $add = -($selshCount - 2);
                $url .= str_repeat( "/", $add );
            }


            // cut $url to array in self::request
            list(self::$_request[ 'controller' ],
                    self::$_request[ 'action' ],
                    self::$_request[ 'vars' ]) = explode( '/', $url, 3 );
        }
    }

    /**
     * This method check if set page for check page for load
     */
    private static function createRouter() {
        if ( empty( self::$_request[ 'vars' ] ) ) {
            self::$_request[ 'vars' ] = array();
        } else {
            self::$_request[ 'vars' ] = explode( '/', self::$_request[ 'vars' ] );
        }


        if ( empty( self::$_request[ 'action' ] ) ) {
            self::$_request[ 'action' ] = self::$confing[ 'defualt' ][ 'action' ];
        }


        if ( empty( self::$_request[ 'controller' ] ) ) {
            self::$_request[ 'controller' ] = self::$confing[ 'defualt' ][ 'controller' ];
        }


        self::$_request[ 'controller' ] = ucfirst( self::$_request[ 'controller' ] ) . 'Controller';
        self::$_request[ 'action' ]     = ucfirst( self::$_request[ 'action' ] ) . 'Action';
    }

    /**
     * This method create alias to main class
     */
    private static function createAlias() {
        foreach (self::$confing['alias'] as $namespace => $class){
            class_alias($namespace, $class);
        }
    }

}
