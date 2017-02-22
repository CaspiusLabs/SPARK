# S.P.A.R.F.
Simple PHP Ajax Response Framework Version 0.1.6.

This is very small PHP 5/7 object oriented framework for handling ajax requests, normal html requests are also supported.

<br/>

<strong>Example:</strong>

http://localhost/index.php?action=test&param1=val1&param2=val2

<br/>

<strong>jQuery Example:</strong>

  $.ajax({url: "index.php", type: "POST", data: { action: "test", param1: "val1", param2: "val2" }, success: function(data) {...}});
  
<br/>

<strong>AngularJS Example:</strong>

  $http.get("index.php", {params:{"action": "test", "param1": val1, "param2": val2}}).then(function (response) {...})
  
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
