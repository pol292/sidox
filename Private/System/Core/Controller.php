<?php

namespace Sidox\Core;

/**
 * ***************************************
 *               Class File              *
 * This is abastract class of controller *
 * ***************************************
 * @version 05/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
abstract class Controller {

    const PATH = PATH_APP . 'Controllers' . DS;

    private $_layout = FALSE;

    public function __construct() {
        View::init();
        if ( method_exists( $this, 'onLoad' ) ) {
            $this->onload();
        }
    }

    public function __destruct() {
        if ( method_exists( $this, 'onFinsh' ) ) {
            $this->onfinsh();
        }
        View::renderLayout( $this->_layout );
    }

    public function setLayout( $layout = 0 ) {
        if ( $layout ) {
            $layout = self::PATH . 'Layouts' . DS . $layout . '.latte';
        }
        if ( File::exsits( $layout )  || $layout == 0) {
            $this->_layout = &$layout;
        }
    }

}
