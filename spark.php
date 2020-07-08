<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Main App Class with common functions
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.1
 * @package Core
 */


abstract class Spark {
	
	protected $DB;

	protected $DNS = DBDRVR.':host='.DBHOST.';dbname='.DBNAME.';charset='.DBCHAR;
	  
	protected $Version = APP_NAME.' Version '.APP_VERSION;
	  
	abstract function index();


// MAGIC CLASS PUBLIC METHODS

	// kickstart
	function __construct() {

		// security check
		$this->RemoveMagicQuotes();
		$this->UnregisterGlobals();

		// init sessions - override by setting this method in Action class
		session_start();

		// init database - override by setting this method in Action class
		if ( !empty( DBDRVR ) ) {

			try {

				$this->DB = new PDO ( $this->DNS, DBUSER, DBPASS );

				$this->DB->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			} catch ( PDOException $exception ) {

				trigger_error( $exception->getMessage(), E_USER_ERROR );

			}
		}
	}

	function __call( $name, $arguments ) {

		// If no method defined fallback to index method
		$this->index();

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

	public static function ErrorHandler( $errno, $errstr, $errfile, $errline ) {

		if ( !(error_reporting() & $errno) ) {

			return false;
		}

		switch ($errno) {

			case E_USER_ERROR:
				self::Error( "Type: [$errno] $errstr<br>File: $errfile<br>Line: $errline" );
				exit(1);
				break;

			case E_USER_WARNING:
				self::Warning( "Type: [$errno] $errstr<br>File: $errfile<br>Line: $errline" );
				break;

			case E_USER_NOTICE:
				self::Notice( "Type: [$errno] $errstr<br>File: $errfile<br>Line: $errline" );
				break;

			default:
				self::Warning( "Type: [$errno] $errstr<br>File: $errfile<br>Line: $errline" );
				break;
		}

		return true;

	}

	public static function FatalErrorHandler() {

		$error = error_get_last();

		self::Error( "Type: [".$error['type']."] ".$error['message']."<br>File: ".$error['file']."<br>Line: ".$error['line'] );
		
	}

	public static function ExceptionHandler( $exception ) {
		
		self::Error( "Uncaught exception: ", $exception->getMessage() );

	}
	
	public static function Debug( $name, $mixed ) {
		
		// for developing purposes only!
		if ( APP_DEV_ENV ) {

			if ( APP_CONSOLE_OUT ) {
				
				self::DisplayConsole( '[ '.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ '.$name.' ]: ', $mixed );

			} else {

				$message = '<strong>'.$name.':</strong> '.print_r( $mixed, true ).'</pre></div>';

				self::DisplayBox( 'Debug', '#9c27b0', $message );

			}

		} else {

			self::Logger( 'Debug', $name.': '.print_r( $mixed, true ) );

		}

	}

	public static function Error( $message ) {
		
		// display error
		if ( APP_DEV_ENV ) {

			if ( APP_CONSOLE_OUT ) {
				
				self::DisplayConsole( '[ '.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ Error ]: ', $message );

			} else {

				self::DisplayBox( 'Error', '#e91e63', $message );

			}

		} else {

			self::Logger( 'Error', $message );

		}

	}

	public static function Warning( $message ) {
		
		// display error
		if ( APP_DEV_ENV ) {

			if ( APP_CONSOLE_OUT ) {
				
				self::DisplayConsole( '[ '.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ Warning ]: ', $message );

			} else {

				self::DisplayBox( 'Warning', '#299515', $message );

			}

		} else {

			self::Logger( 'Warning', $message );

		}

	}

	public static function Notice( $message ) {
		
		// display error
		if ( APP_DEV_ENV ) {

			if ( APP_CONSOLE_OUT ) {
				
				self::DisplayConsole( '[ '.APP_NAME.' ]::[ Version '.APP_VERSION.' ]::[ Notice ]: ', $message );

			} else {

				self::DisplayBox( 'Notice', '#0072ff', $message );

			}

		} else {

			self::Logger( 'Notice', $message );

		}

	}

	public static function DisplayConsole( $name, $mixed ) {
		
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

	public static function DisplayBox( $name, $hexcolor, $message ) {

		echo '<div style="width: auto;box-sizing: border-box;margin: 5px;padding: 1px;background-image: linear-gradient(115deg,#4fcf70,#fad648,#a767e5,#12bcfe,#44ce7b);border-radius: 6px;box-sizing: border-box;color: '.$hexcolor.';font-family: monospace;font-weight: lighter;font-size: 1rem;">';

		echo '<strong>&nbsp;&nbsp;'.APP_NAME.' ]::[ v'.APP_VERSION.' ]::[ '.$name.' ]:</strong>';

		echo '<pre style="margin: 5px;padding: 5px;background: #000;border-radius: 6px;box-sizing: border-box;color: #fff;">'.$message.'</pre></div>';

	}
	
	public static function Logger( $type = null, $message ) {
		
		// write log file
		error_log( date( "[Y-m-d H:i:s] ") . "[" . $type . "]: " . NoWrap($message) . "\r\n", 3, APP_LOG );

	}

	public static function NoWrap( $string ) {
		
		// remowe wrap characters from strings
		return str_replace( array( "\n\r", "\n", "\r" ), "", $string );

	}

	public static function TrimAll( $string, $chars = " \t\n\r\0\x0B" ) {
		
		// trim whole string
		return str_replace(str_split($chars), '', $string);

	}

	public static function Textual( $datetime ) {
		
		// format textual date
		return date('l jS \o\f F Y \a\t G:i A.', strtotime( $datetime ));

	}

	public static function ArrayToObject( $array ) {
		
		// make object out of array
		if ( !is_array($array) ) {
			
			return $array;

		}

		$object = new stdClass();
		
		if ( is_array($array) && count($array) > 0 ) {
			
			foreach ( $array as $name=>$value ) {
				$name = strtolower(trim($name));
				if ( !empty($name) )
				$object->$name = ArrayToObject($value);
			}
			
			return $object;
		
		} else
		
			return false;

	}

	public static function Literal( $array ) {
		
		// literal array
		$result = '';
		if ( is_array($array) ) {

			foreach ( $array as $value ) {
				$result.= $value.' ';
			}
			return $result;
		}

	}

	public static function IsAjax() {
		
		// check if request is ajax type
		return !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest';

	}


// HELPER PROTECTED METHODS

	protected function ParseTemplate( $file_name, $vars = array() ) {		
		
		// parse html file with php language like <?php echo $var >
		ob_start();
		
		extract($vars);
			
		require($file_name);
		
		$applied_template = ob_get_contents();
			
		ob_end_clean();
		
		return $applied_template;

	}

	protected function StripSlashesDeep( $value ) {
		
		// check for Magic Quotes and remove them
		$value = is_array( $value ) ? array_map( 'StripSlashesDeep', $value ) : stripslashes( $value );

		return $value;

	}

		
// PRIVATE SECURITY METHODS

	private function RemoveMagicQuotes() {

		if ( get_magic_quotes_gpc() ) {

			$_GET = $this->StripSlashesDeep( $_GET );
			$_POST = $this->StripSlashesDeep( $_POST );
			$_COOKIE = $this->StripSlashesDeep( $_COOKIE );
			$_SESSION = $this->StripSlashesDeep( $_SESSION );

		}

	}
	
	private function UnregisterGlobals() {
		
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
	
// END OF SPARK CLASS
}
