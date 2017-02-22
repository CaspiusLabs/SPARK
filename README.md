# S.P.A.R.F
Simple PHP Ajax Response Framework Version 0.1.6.

<strong>Description:</strong>

This is very small PHP 5/7 object oriented framework for handling ajax requests, normal html requests are also supported.

<strong>Example:</strong>

http://localhost/test.php?action=test&first=1param&second=1param


<strong>jQuery Example:</strong>

  $.ajax({type: "POST", data: { action: "test", 1st: "param", 2nd: "param" }, success: function(data) {}});
  
<strong>PHP Example:</strong>
  
    class Action extends App {

      function ajax_test( $action, $param1, $param2 ) {

        echo "This is test function called from ajax query and this is my values $param1 $param2";

      }
	
      function test( $action, $param1, $param2 ) {

        echo "This is test function called from url query and this is my values $param1 $param2";

      }

    }
