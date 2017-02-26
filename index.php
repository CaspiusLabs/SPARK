<?php
/**
 * Simple PHP Ajax Response Framework
 *
 * Bootstrap and routing functions
 *
 * @author Caspius Labs
 * @link https://github.com/caspius/SPARF
 * @version 0.1.7
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

	echo "<big>S.P.A.R.F. Error:</big> call hook class not found.";

}
