<?php
/**
 * Simple PHP Ajax Response Kit
 *
 * Common functions
 *
 * @author Caspius Labs
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 1.1.8
 * @package Utils
 *
 */


// for developing purposes only!

function debug( $mixed ) {

	echo '<pre>'.print_r( $mixed, true ).'</pre>';

}

function debug_name( $name = '', $mixed ) {

  echo '<pre><big>'.$name.'</big>'.print_r($mixed, true).'</pre>';

}


// send output of print_r to javascript console

function debug_console( $mixed ) {

  echo "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}";

  $output = explode("\n", print_r($mixed, true));

  foreach ($output as $line) {
    if (trim($line)) {
      $line = addslashes($line);
      echo "console.log(\"{$line}\");";
    }
  }

  echo "\r\n//]]>\r\n</script>";

}


// send output of print_r to xml

function debug_xml( $mixed, $echo = false ) {

    // capture the output of print_r
    $out = print_r($mixed, true);

    // Replace the root item with a struct
    // MATCH : '<start>element<newline> ('
    $root_pattern = '/[ \t]*([a-z0-9 \t_]+)\n[ \t]*\(/i';
    $root_replace_pattern = '<struct name="root" type="\\1">';
    $out = preg_replace($root_pattern, $root_replace_pattern, $out, 1);

    // Replace array and object items structs
    // MATCH : '[element] => <newline> ('
    $struct_pattern = '/[ \t]*\[([^\]]+)\][ \t]*\=\>[ \t]*([a-z0-9 \t_]+)\n[ \t]*\(/miU';
    $struct_replace_pattern = '<struct name="\\1" type="\\2">';
    $out = preg_replace($struct_pattern, $struct_replace_pattern, $out);
    // replace ')' on its own on a new line (surrounded by whitespace is ok) with '</var>
    $out = preg_replace('/^\s*\)\s*$/m', '</struct>', $out);

    // Replace simple key=>values with vars
    // MATCH : '[element] => value<newline>'
    $var_pattern = '/[ \t]*\[([^\]]+)\][ \t]*\=\>[ \t]*([a-z0-9 \t_\S]+)/i';
    $var_replace_pattern = '<var name="\\1">\\2</var>';
    $out = preg_replace($var_pattern, $var_replace_pattern, $out);

    $out =  trim($out);
    $out='<?xml version="1.0"?><data>'.$out.'</data>';

    if (!$echo)
      echo $out;
    else
      return $out;

}


// write log file

function writeLog( $type = null, $message ) {

	error_log( date( "[Y-m-d H:i:s] ") . $type . ": " . call_user_func_array( 'sprintf', $message ) . "\r\n", 3, APP_LOG );

}


// remowe wrap characters from strings

function noWrap( $string ) {

	return str_replace( array( "\n\r", "\n", "\r" ), "", $string );

}


// trim whole string

function trimall( $string, $chars = " \t\n\r\0\x0B" ) {

	return str_replace(str_split($chars), '', $string);

}


// format textual date

function textual( $datetime ) {

	return date('l jS \o\f F Y \a\t G:i A.', strtotime( $datetime ));

}


// make object out of array

function arrayToObject($array) {

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


// literal array

function literal($array) {

	$result = '';
	if(is_array($array)){
		foreach ($array as $value) {
			$result.= $value.' ';
		}
		return $result;
	}

}


// check if request is ajax

function isAjax() {

	return !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest';

}


// check if development environment and display errors

function setReporting() {

	if ( APP_DEV_ENV ) {

	    ini_set( 'error_reporting', E_ALL );
	    ini_set( 'display_errors', 1 );

	} else {

	    ini_set( 'error_reporting', 0 );
	    ini_set( 'display_errors', 0 );

	}

}


// check for Magic Quotes and remove them

function stripSlashesDeep( $value ) {

	$value = is_array( $value ) ? array_map( 'stripSlashesDeep', $value ) : stripslashes( $value );

	return $value;

}


function removeMagicQuotes() {

	if ( get_magic_quotes_gpc() ) {

		$_GET = stripSlashesDeep( $_GET );
		$_POST = stripSlashesDeep( $_POST );
		$_COOKIE = stripSlashesDeep( $_COOKIE );
		$_SESSION = stripSlashesDeep( $_SESSION );

	}

}


// check register globals and remove them

function unregisterGlobals() {

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


// class autoload

function __autoload( $className ) {

	$class = strtolower( $className ).'.php';

	if ( file_exists( $class ) ) {

		include_once $class;

	}

}
