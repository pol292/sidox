<?php

namespace Sidox\Core;

/**
 * **************************************
 *              Class Model             *
 * This class for load and create model *
 * **************************************
 * @version 06/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
class Model {

    const PATH = PATH_APP . "Models" . DS;

    /**
     * @var array This is array of referance to singelton model
     */
    private static $_modelInstance = array();

    /**
     * This method load modal in singelton
     * @param string $model The name of model
     * @return Model The instance of currnet model
     */
    public static function load( $model ) {

        //TODO: update singelton to multi same name
        
        $modelName = strrpos( $model, "::" );
        if ( isset( $model ) && $modelName > 0 ) {
            $modelName += 2;
        }
        $modelName = substr( $model, $modelName );
        if ( isset( self::$_modelInstance[ $modelName ] ) ) {
            return self::$_modelInstance[ $modelName ];
        } else {

            $filePath = File::shortLoad( $model );
            $filePath = self::PATH . $filePath;

            if ( File::exsits( $filePath ) ) {
                require_once $filePath;
                $model                              = new $modelName();
                self::$_modelInstance[ $modelName ] = $model;
                return $model;
            }
        }
    }

}
