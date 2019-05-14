<?php
/**
 * Simple PHP Ajax Response Kit
 *
 * Bootstrap and routing functions
 *
 * @author Caspius Labs
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 1.1.8
 * @package Core
 *
 */


require_once 'config.php'; // must run as first
require_once 'common.php'; // must run as second

setReporting();
removeMagicQuotes();
unregisterGlobals();


// call hook class

$callhook = key($_REQUEST);

if ( class_exists( $callhook ) ) {

	$app = $callhook;

	$app = new $app();

	$ajax = isAjax() ? AJAXHOOK : '';

	if ( isset( $_REQUEST[$callhook] ) ) {

		call_user_func_array( array( $app, $ajax.$_REQUEST[$callhook] ), $_REQUEST );

	} else {

		call_user_func_array( array( $app, $ajax.DEFAULTHOOK), $_REQUEST );

	}

} else {

	echo "<strong>".APP_NAME." Fatal Error:</strong> call hook class not found. Check configuration file or reinstall.";

}
