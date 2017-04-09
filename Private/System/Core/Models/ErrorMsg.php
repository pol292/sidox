<?php

namespace Sidox\Core\Models;

trait ErrorMsg {

    private $_errors = FALSE;

    public function setError( $error, $msg ) {
        if ( is_array( $msg ) && is_array( $this->_errors ) ) {
            $this->_errors[ $error ] = array_merge( $this->_errors[ $error ], $msg );
        } elseif ( is_array( $msg ) ) {
            $this->_errors[ $error ] = $msg;
        } else {
            $this->_errors[ $error ] = $msg;
        }
    }

    public function getError( $error ) {
        if ( !empty( $this->_errors[ $error ] ) ) {
            return $this->_errors[ $error ];
        }
        return NULL;
    }

}
