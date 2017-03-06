<?php

defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );

defined( 'PATH_BASE' ) or define( 'PATH_BASE', substr( dirname( realpath( __FILE__ ) ), 0, -6 ) );
defined( 'PATH_PUBLIC' ) or define( 'PATH_PUBLIC', PATH_BASE . 'Public' . DS );
defined( 'PATH_PRIVATE' ) or define( 'PATH_PRIVATE', PATH_BASE . 'Private' . DS );
defined( 'PATH_SYS' ) or define( 'PATH_SYS', PATH_PRIVATE . 'System' . DS );
defined( 'PATH_APP' ) or define( 'PATH_APP', PATH_PRIVATE . 'Application' . DS );

$url = substr( $_SERVER[ 'PHP_SELF' ], 0, -9 );
defined( 'URL_HOST' ) or define( 'URL_HOST', $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'SERVER_NAME' ] );
defined( 'URL' ) or define( 'URL', URL_HOST . $url );
defined( 'URL_SHORT' ) or define( 'URL_SHORT', substr( $url, 0, -7 ) );
unset( $url );

require_once PATH_BASE . 'vendor' . DS . 'autoload.php';
Sidox\Core\Route::init( 'main' );
