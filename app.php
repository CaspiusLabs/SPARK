<?php
/**
 * ✨💥✨ </SPARK> ✨💥✨
 * Simple.PHP.Ajax.Request.Kit
 *
 * Main application class
 *
 * @author Caspius Labs💖
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 2.0.1
 * @package App
 */

class App extends Spark {

    function index() {

        echo "This is default request index method!";

    }

    function ajax_index() {

        echo "This is default ajax request index method!";

    }
    
    function test( $action, $param1='', $param2='' ) {
        
        echo "This is test function called from query string and this is my values:";
        
        self::Debug('$action', $action);
        self::Debug('$params', $param1);
        self::Debug('$params', $param2);
        
    }
    
    function ajax_test( $action, $params ) {

        echo "This is test function called from ajax request.";

    }

}
