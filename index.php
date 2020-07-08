<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Bootstrap and routing functions
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.1
 * @package Core
 */


require_once 'config.php'; // must run as first (best to place in safe unreadable directory!)
include_once 'spark.php';  // must run as second


// check if development environment is turned on
if ( APP_DEV_ENV ) {
	
	// if yes display all erros
	ini_set( 'error_reporting', E_ALL );
	ini_set( 'display_errors', 0 );

	// and turn on custom error handlers
	set_error_handler( array( 'Spark', 'ErrorHandler' ) );
	set_exception_handler( array( 'Spark', 'ExceptionHandler' ) );
	register_shutdown_function( array( 'Spark', 'FatalErrorHandler' ) );
	
} else {
	
	// if not display nothing
	ini_set( 'error_reporting', 0 );
	ini_set( 'display_errors', 0 );
	
}


// parse uri request
$url = parse_url( trim( $_SERVER['REQUEST_URI'], '/') );

// check if pretty urls are used
if ( !empty($url['path']) && $url['path'] != 'index.php' ) {

	$arguments = explode('/', $url['path'] );

// if not try with standard urls
} else if ( !empty($url['query']) ) {

	parse_str($url['query'], $query);

	foreach ( $query as $key => $val ) {
		
		$arguments[] = $key;
		$arguments[] = $val;
		
	}

// if no url given fallback to default request
} else {

	$arguments = $_REQUEST;

}


// define call hook arguments
$class  = isset( $arguments[0] ) ? $arguments[0] : APP_CALLHOOK;
$method = isset( $arguments[1] ) ? $arguments[1] : APP_INDEXHOOK;


// init call hook class
if ( class_exists( $class ) ) {

	callHook( $class, $method, $arguments );

} else if ( class_exists( APP_CALLHOOK ) ) {

	callHook( APP_CALLHOOK, $method, $arguments );

} else {
	
	trigger_error( "Call hook '".APP_CALLHOOK."' class missing! Check config file or reinstall.", E_USER_ERROR );

}


// launch call hook class function
function callHook( $call, $hook, $params ) {

	$app = new $call();

	$ajax = Spark::IsAjax() ? APP_AJAXHOOK : '';
	
	call_user_func_array( array( $app, $ajax.$hook), $params );
	
}


// autoload call hook class function
function __autoload( $className ) {

	$class = strtolower( $className ).'.php';

	if ( file_exists( $class ) ) {

		include_once $class;

	}

}