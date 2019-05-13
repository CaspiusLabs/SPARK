<?php
/**
 * Simple PHP Ajax Response Kit
 *
 * Main App Class
 *
 * @author Caspius Labs
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 0.1.7
 * @package App
 *
 */


class App {

		protected $version = APP_NAME.' Version '.APP_VERSION;

  	protected $error = APP_NAME.' Error ';

  	protected $DNS = DBDRVR.':host='.DBHOST.';dbname='.DBNAME.';charset='.DBCHAR;

  	protected $DB;


		function __construct() {


      // init sessions - override by setting this method in Action class

      session_start();


      // init database - override by setting this method in Action class

	    if ( !empty( DBDRVR ) ) {

	        try {

	            $this->DB = new PDO ( $this->DNS, DBUSER, DBPASS );

	            $this->DB->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	        } catch ( PDOException $exception ) {

	            echo $this->error."[Database Connection]: ".$exception->getMessage()."\r\n";

	        }

				}

    }


		function __call( $name, $arguments ) {

			// Display framework version if no action method defined in Action class

			echo $this->version;

		}


	 	function __set( $name, $value ) {

	 		// Save value in session if no properties defined in Action class

	 		$_SESSION[$name] = $value;

	 	}


		function __get( $name ) {

			// Load value from session if no properties defined in Action class

			return $_SESSION[$name];

		}


		function __isset( $name ) {

	  	return isset( $_SESSION[$name] );

	  }


		function __unset( $name ) {

	 		unset( $_SESSION[$name] );

	  }


		function __destruct() {

			// cleanup - override by setting this method in Action class

			unset( $this->DB );

			session_write_close();

		}

}
