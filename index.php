<?php
/**
 * Simple PHP Ajax Response Framework
 *
 * Bootstrap and routing functions
 *
 * @author Caspius Labs
 * @link https://github.com/caspius/S.P.A.R.F
 * @version 0.1.6
 * @package Core
 *
 */


require_once 'config.php'; // must run as first
require_once 'common.php'; // must run as second

setReporting();
removeMagicQuotes();
unregisterGlobals();


// call hook

if ( class_exists( CALLHOOK ) ) {

	$app = CALLHOOK;

	$app = new $app();

	$ajax = isAjax() ? AJAXHOOK : '';

	if ( isset( $_REQUEST[CALLHOOK] ) ) {

		call_user_func_array( array( $app, $ajax.$_REQUEST[CALLHOOK] ), $_REQUEST );

	} else {
	
		call_user_func_array( array( $app, $ajax.DEFAULTHOOK), $_REQUEST );

	}

} else {

	echo "<big>S.P.A.R. Framework Error:</big> check configuration file or reinstall.";

}
