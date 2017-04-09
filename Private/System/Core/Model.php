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
    ############################################################################
    ####                          Static Methods                            ####
    ############################################################################

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


        if ( isset( self::$_modelInstance[ $model ] ) ) {
            return self::$_modelInstance[ $model ];
        } else {
            $modelPath = self::PATH . $model;
            File::shortLoad( $modelPath );
            if ( File::exsits( $modelPath ) ) {
                require_once $modelPath;

                $modelName = strrpos( $model, "::" );
                if ( $modelName > 0 ) {
                    $modelName += 2;
                }
                $modelName = substr( $model, $modelName );

                $modelInstance                          = new $modelName();
                self::$_modelInstance[ $model ] = $modelInstance;
                return $modelInstance;
            }
        }
    }

    ############################################################################
    ####                          Object Methods                            ####
    ############################################################################

    

}
