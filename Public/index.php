<?php

defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );
defined( 'BASE_PATH' ) or define( 'BASE_PATH', substr(dirname( realpath( __FILE__ ) ), 0, -6) );

require_once BASE_PATH . 'vendor' . DS . 'autoload.php';
Sidox\Core\Route::init( 'main' );
