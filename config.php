<?php
/**
 * Simple PHP Ajax Response Framework
 *
 * Configuration file
 *
 * @author Caspius Labs
 * @link https://github.com/caspius/S.P.A.R.F
 * @version 0.1.6
 * @package Core
 *
 */


// session (last 1 days)
ini_set( 'session.cookie_lifetime', 60 * 60 * 24 * 1 );
ini_set( 'session.gc_maxlifetime', 60 * 60 * 24 * 1 );

// database
//define( 'DBDRVR', 'mssql' );
define( 'DBDRVR', 'mysql' ); // leave 'DBDRVR' empty if no database is used
define( 'DBHOST', '127.0.0.1' );
define( 'DBNAME', '' );
define( 'DBUSER', '' );
define( 'DBPASS', '' );
define( 'DBCHAR', 'utf8' );

// environment
define( 'APP_NAME', '' );
define( 'APP_VERSION', '0.0.1' );
define( 'APP_DEV_ENV', TRUE);

// call hooks
define( 'AJAXHOOK', 'ajax_' );
define( 'CALLHOOK', 'action' );
define( 'DEFAULTHOOK', 'index' );

// folders
define( 'DS', '/' );
define( 'APP_PATH', dirname( $_SERVER['SCRIPT_FILENAME'] ) );
define( 'APP_ROOT', rtrim( APP_PATH, dirname( $_SERVER['SCRIPT_NAME'] ) ) );
define( 'APP_LOG', APP_PATH.DS.'app.log' );

