<?php
/**
 * Simple PHP Ajax Response Kit
 *
 * Define all actions class
 *
 * @author Caspius Labs
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 1.1.8
 * @package App
 *
 */


class Action extends App {

    function ajax_test( $action, $param1="1", $param2="2" ) {

        echo "This is test function called from ajax query and this is my values $param1 $param2";

    }

    function test( $action, $param1="1", $param2="2" ) {

        echo "This is test function called from url query and this is my values $param1 $param2";

    }

}
