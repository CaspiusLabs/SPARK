 # ✨&lt;/SPARK&gt;✨
 ## **Simple.PHP.Ajax.Request.Kit**
 ### **Version 2.0.0**

This is PHP 5/7 object oriented micro framework, allows to make simple or complex web pages much easier:
* Specyfically designed to build Single Page Applications (SPA), by easy handling ajax requests or query strings.
* Very usable for creating Rest API systems. 
* Fast starting point for your web application or website!

<br/>

<strong>Query string example:</strong>

http://localhost/index.php?app=test&param1=val1&param2=val2

<br/>

<strong>jQuery example:</strong>

```javascript
$.ajax({url: "index.php", type: "POST", data: { app: "test", param1: "val1", param2: "val2" }, success: function(data) {...}});
```

<br/>

<strong>AngularJS example:</strong>

```javascript
$http.get("index.php", {params:{"app": "test", "param1": val1, "param2": val2}}).then(function (response) {...})
```

<br/>

<strong>React example:</strong>

```javascript
async function getAjax(data) {
  const response = await fetch('http://localhost/index.php?app=test&param1=val1&param2=val2', {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
      "Content-type": "application/json; charset=UTF-8"
    }
  });
}
```

<br/>

<strong>Vue.js example:</strong>

```javascript
new Vue({
    el: '#app',
    created() {
        this.fetchData();	
    },
    data: {
        values: []
    },
    methods: {
        fetchData() {
        axios.get('http://localhost/index.php?app=test&param1=val1&param2=val2').then(response => {
            this.values = response.data;
            });
        }
    }
});
```

<br/>

<strong>PHP Example:</strong>

```php  
class App extends Spark {

  function ajax_test( $action, $param1, $param2 ) {

    echo "This is test function called from ajax query and this is my values $param1 $param2";

  }

  function test( $action, $param1, $param2 ) {

    echo "This is test function called from url query and this is my values $param1 $param2";

  }

}
```

<br/>

<strong>Debug and error box messages example:</strong>

```php
class App extends Spark {

    function index( $action, $params ) {

        // inside class definition
        $this->error( "No '$action' method defined in Action class!" );

        $this->debug( '$_REQUEST', $_REQUEST );

    }

}

// outside class definition
Spark::error( message );

Spark::debug( variable name, variable );
```

<br/>

<strong>Result:</strong>

![spark](https://user-images.githubusercontent.com/429627/85475800-fa864400-b5b6-11ea-8fdc-c29d82f597bd.png)