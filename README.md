# S.P.A.R.F
Simple PHP Ajax Response Framework Version 0.1.6.

This is very small PHP 5/7 object oriented framework for handling ajax requests, normal html requests are also supported.

<br/>

<strong>Example:</strong>

http://localhost/index.php?action=test&first=param1&second=param2

<br/>

<strong>jQuery Example:</strong>

  $.ajax({type: "POST", data: { action: "test", first: "param1", second: "param2" }, success: function(data) { console.log(data) }});
  
<br/>
  
<strong>PHP Example:</strong>
  
    class Action extends App {

      function ajax_test( $action, $param1, $param2 ) {

        echo "This is test function called from ajax query and this is my values $param1 $param2";

      }
	
      function test( $action, $param1, $param2 ) {

        echo "This is test function called from url query and this is my values $param1 $param2";

      }

    }
