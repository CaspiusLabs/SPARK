<?php
/**
 * Simple PHP Ajax Response Framework
 *
 * Common functions
 *
 * @author Caspius Labs
 * @link https://github.com/caspius/S.P.A.R.F
 * @version 0.1.6
 * @package Utils
 *
 */


// for developing purposes only!

function debug( $mixed ) {

	echo '<pre>'.print_r( $mixed, true ).'</pre>';

}


// remowe wrap characters from strings

function noWrap( $string ) {

    return str_replace( array( "\n\r", "\n", "\r" ), "", $string );

}


// check if request is ajax

function isAjax() {

	return !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest';

}


// check if development environment and display errors
 
function setReporting() {

	if ( APP_DEV_ENV ) {

	    ini_set( 'error_reporting', E_ALL );
	    ini_set( 'display_errors', 1 );

	} else {

	    ini_set( 'error_reporting', 0 );
	    ini_set( 'display_errors', 0 );

	}

}


// write log file

function writeLog( $type = null, $message ) {

	error_log( date( "[Y-m-d H:i:s] ") . $type . ": " . call_user_func_array( 'sprintf', $message ) . "\r\n", 3, APP_LOG );

}


// check for Magic Quotes and remove them
 
function stripSlashesDeep( $value ) {

    $value = is_array( $value ) ? array_map( 'stripSlashesDeep', $value ) : stripslashes( $value );
    
    return $value;

}


function removeMagicQuotes() {

	if ( get_magic_quotes_gpc() ) {

	    $_GET = stripSlashesDeep( $_GET );
	    $_POST = stripSlashesDeep( $_POST );
	    $_COOKIE = stripSlashesDeep( $_COOKIE );
	    $_SESSION = stripSlashesDeep( $_SESSION );

	}

}

 
// check register globals and remove them
 
function unregisterGlobals() {

    if ( ini_get('register_globals') ) {

        $array = array( '_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES' );

        foreach ( $array as $value ) {

            foreach ( $GLOBALS[$value] as $key => $var ) {

                if ( $var === $GLOBALS[$key] ) {

                    unset( $GLOBALS[$key] );

                }

            }

        }

    }

}


// class autoload

function __autoload( $className ) {

	$class = strtolower( $className ).'.php';

	if ( file_exists( $class ) ) {

		include_once $class;

	}

}
