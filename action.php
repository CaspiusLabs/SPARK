<?php
/**
 * Simple PHP Ajax Response Framework
 *
 * Define all actions class
 *
 * @author Caspius Labs
 * @link https://github.com/caspius/S.P.A.R.F
 * @version 0.1.6
 * @package Core
 *
 */


class Action extends App {

    function ajax_test( $action, $param1, $param2 ) {

        echo "This is test function called from ajax query";

    }
	
    function test( $action, $param1, $param2 ) {

        echo "This is test function called from url query";

    }

}
