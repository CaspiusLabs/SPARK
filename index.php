<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Bootstrap and routing functions
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.0
 * @package Core
 */


require_once 'config.php'; // must run as first (best to place in safe unreadable directory!)
include_once 'spark.php';  // must run as second


// call hook class
$callhook = key($_REQUEST);

if ( class_exists( $callhook ) ) {

	$app = $callhook;

	$app = new $app();

	$ajax = Spark::isAjax() ? 'ajax_' : '';

	call_user_func_array( array( $app, $ajax.$_REQUEST[$callhook] ), $_REQUEST );

} else {

	Spark::error("Call hook '$callhook' class missing!");
	
	Spark::debug('$_REQUEST', $_REQUEST);

}
