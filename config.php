<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Configuration file
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.0
 * @package Core
 */

// session (last 1 days)
ini_set( 'session.cookie_lifetime', 60 * 60 * 24 * 1 );
ini_set( 'session.gc_maxlifetime', 60 * 60 * 24 * 1 );

// database
define( 'DBDRVR', '' ); // leave 'DBDRVR' empty if no database is used
define( 'DBHOST', '127.0.0.1' );
define( 'DBNAME', '' );
define( 'DBUSER', '' );
define( 'DBPASS', '' );
define( 'DBCHAR', 'utf8' );

// environment
define( 'APP_NAME', '✨ &lt;/SPARK&gt; ✨' ); // you can change this for your app name and version :}
define( 'APP_VERSION', '2.0.0' );
define( 'APP_DEV_ENV', TRUE ); // should all error and debug mesagges be visible? (on production server better not!)

// options
define( 'APP_CONSOLE_OUT', FALSE ); // should all error and debug messages be visible in console log?
define( 'APP_AUTOINDEX', TRUE ); // should launch index method when action method is not defined?

// folders
define( 'DS', '/' );
define( 'APP_PATH', dirname( $_SERVER['SCRIPT_FILENAME'] ) );
define( 'APP_ROOT', rtrim( APP_PATH, dirname( $_SERVER['SCRIPT_NAME'] ) ) );
define( 'APP_LOG', APP_PATH.DS.'app.log' );
