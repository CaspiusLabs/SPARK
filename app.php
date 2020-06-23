<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Main application class
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.0
 * @package App
 */

class App extends Spark {

    function index( $action, $params ) {

        echo "This is main index method and this is my values:";

        self::debug('$action', $action);
        self::debug('$params', $params);

    }

    function ajax_index( $action, $params ) {

        echo "This is main ajax request index method!";

    }
    
    function test( $action, $param1='', $param2='' ) {
        
        echo "This is test function called from query string and this is my values:";
        
        self::debug('$action', $action);
        self::debug('$params', $param1);
        self::debug('$params', $param2);
        
    }
    
    function ajax_test( $action, $params ) {

        echo "This is test function called from ajax request.";

    }

}
