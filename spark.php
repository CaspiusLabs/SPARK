<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Main App Class with common functions
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.0
 * @package Core
 */


abstract class Spark {
	
	protected $DB;

	protected $DNS = DBDRVR.':host='.DBHOST.';dbname='.DBNAME.';charset='.DBCHAR;
	  
	protected $version = APP_NAME.' Version '.APP_VERSION;
	  
	abstract protected function index( $name, $arguments );


// MAGIC CLASS PUBLIC METHODS

	// kickstart
	function __construct() {

		// security check
		$this->setReporting();
		$this->removeMagicQuotes();
		$this->unregisterGlobals();

		// init sessions - override by setting this method in Action class
		session_start();

		// init database - override by setting this method in Action class
		if ( !empty( DBDRVR ) ) {

			try {

				$this->DB = new PDO ( $this->DNS, DBUSER, DBPASS );

				$this->DB->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			} catch ( PDOException $exception ) {

				error($exception->getMessage());

			}
		}
	}

	function __call( $name, $arguments ) {

		if ( APP_AUTOINDEX ) {

			if ( $this->isAjax() ) {

				$this->ajax_index( $name, $arguments );
			
			} else {

				$this->index( $name, $arguments );
			
			}

		} else {

			// No action method defined in Action class
			$this->error( "No '$name' method defined in Action class!" );
			
			$this->debug( '$_REQUEST', $_REQUEST );

			$this->debug( '$_SERVER', $_SERVER );

			if ( !APP_DEV_ENV ) {
				
				header('HTTP/1.0 404 Not Found');

			}
			
			die;

		}

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


// HELPER PUBLIC STATIC METHODS

	public static function debugConsole( $name, $mixed ) {
		
		// send output of print_r to javascript console
		echo "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}";

		$output = explode("\n", print_r($mixed, true));
		$name = html_entity_decode($name);

		echo "console.log(\"$name\");";

		foreach ($output as $line) {

			if (trim($line)) {

				$line = addslashes($line);
				echo "console.log(\"{$line}\");";
			}
		}

		echo "console.log('');";
		echo "\r\n//]]>\r\n</script>";

	}
	
	public static function debug( $name, $mixed ) {
		
		// for developing purposes only!
		if ( APP_DEV_ENV ) {

			if ( APP_CONSOLE_OUT ) {
			
				self::debugConsole( '[ '.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ '.$name.' ]: ', $mixed );

			} else {

				echo '<div style="margin: 5px;padding: 1px;background-image: linear-gradient(115deg,#4fcf70,#fad648,#a767e5,#12bcfe,#44ce7b);border-radius: 6px;box-sizing: border-box;color: #9c27b0;font-family: monospace;font-weight: lighter;font-size: large;">';

				echo '<strong>&nbsp;&nbsp;'.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ Debug ]:</strong>';
					
				echo '<pre style="margin: 5px;padding: 5px;background: #000;border-radius: 6px;box-sizing: border-box;color: #fff;">';

				echo '<strong>'.$name.':</strong> '.print_r( $mixed, true ).'</pre></div>';

			}

		} else {

			self::logger( 'Debug', $name.': '.print_r( $mixed, true ) );

		}

	}

	public static function error( $message ) {
		
		// display error
		if ( APP_DEV_ENV ) {

			if ( APP_CONSOLE_OUT ) {
			
				self::debugConsole( '[ '.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ Error ]: ', $message );

			} else {

				echo '<div style="margin: 5px;padding: 1px;background-image: linear-gradient(115deg,#4fcf70,#fad648,#a767e5,#12bcfe,#44ce7b);border-radius: 6px;box-sizing: border-box;color: #e91e63;font-family: monospace;font-weight: lighter;font-size: large;">';

				echo '<strong>&nbsp;&nbsp;'.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ Error ]:</strong>';

				echo '<pre style="margin: 5px;padding: 5px;background: #000;border-radius: 6px;box-sizing: border-box;color: #fff;">'.$message.'</pre>';

				echo '</div>';

			}

		} else {

			self::logger( 'Error', $message );

		}

	}
	
	public static function logger( $type = null, $message ) {
		
		// write log file
		error_log( date( "[Y-m-d H:i:s] ") . "[" . $type . "]: " . nowrap($message) . "\r\n", 3, APP_LOG );

	}

	public static function nowrap( $string ) {
		
		// remowe wrap characters from strings
		return str_replace( array( "\n\r", "\n", "\r" ), "", $string );

	}

	public static function trimall( $string, $chars = " \t\n\r\0\x0B" ) {
		
		// trim whole string
		return str_replace(str_split($chars), '', $string);

	}

	public static function textual( $datetime ) {
		
		// format textual date
		return date('l jS \o\f F Y \a\t G:i A.', strtotime( $datetime ));

	}

	public static function arrayToObject( $array ) {
		
		// make object out of array
		if(!is_array($array))
		return $array;

		$object = new stdClass();
		if (is_array($array) && count($array) > 0) {
		foreach ($array as $name=>$value) {
			$name = strtolower(trim($name));
			if (!empty($name))
				$object->$name = arrayToObject($value);
		}
		return $object;
		} else
		return false;

	}

	public static function literal( $array ) {
		
		// literal array
		$result = '';
		if(is_array($array)){
			foreach ($array as $value) {
				$result.= $value.' ';
			}
			return $result;
		}

	}

	public static function isAjax() {
		
		// check if request is ajax type
		return !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest';

	}


// HELPER PROTECTED METHODS

	protected function displayTemplate( $file_name, $vars = array() ) {		
		
		// parse html file with php language like <?php echo $var >
		ob_start();
		
		extract($vars);
			
		require($file_name);
		
		$applied_template = ob_get_contents();
			
		ob_end_clean();
		
		return $applied_template;

	}

	protected function stripSlashesDeep( $value ) {
		
		// check for Magic Quotes and remove them
		$value = is_array( $value ) ? array_map( 'stripSlashesDeep', $value ) : stripslashes( $value );

		return $value;

	}

		
// PRIVATE SECURITY METHODS

	private function setReporting() {
		
		// check if development environment and display errors
		if ( APP_DEV_ENV ) {
			
			ini_set( 'error_reporting', E_ALL );
			ini_set( 'display_errors', 1 );
			
		} else {
			
			ini_set( 'error_reporting', 0 );
			ini_set( 'display_errors', 0 );
			
		}
		
	}

	private function removeMagicQuotes() {

		if ( get_magic_quotes_gpc() ) {

			$_GET = $this->stripSlashesDeep( $_GET );
			$_POST = $this->stripSlashesDeep( $_POST );
			$_COOKIE = $this->stripSlashesDeep( $_COOKIE );
			$_SESSION = $this->stripSlashesDeep( $_SESSION );

		}

	}
	
	private function unregisterGlobals() {
		
		// check register globals and remove them
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

}

// END OF SPARK CLASS

function __autoload( $className ) {
		
	// class autoload
	$class = strtolower( $className ).'.php';

	if ( file_exists( $class ) ) {

		include_once $class;

	}

}