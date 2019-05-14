# S.P.A.R.K.
Simple PHP Ajax Response Kit Version 1.1.8

This is minimal PHP 5/7 object oriented framework kit for handling ajax requests, normal html requests are also supported.
Usable for creating API systems or buidling Single Page Applications.

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
