# Zynamo Templating Engine
Zynamo is a very simple templating engine written in PHP. It was developed to be used to substitute commonly typed words and characters with a key which can be called in a <strong>PHP</strong> script.  

## Start using Zynamo
To begin using Zynamo, firstly open `zynamo_config.php`. You'll find an empty array called "items". This is where you store keys linking to their value. Zynamo uses the `key =&gt; value` format, and is the format you are required to use to store keys.  

### Example
Here's a short demo showing you how to use Zynamo. In this demo, a key will be stored inside `zynamo_config.php`, and then in a new file called `index.php`, we will include `zynamo_config.php` and `zynamo_processor.php`.  

`zynamo_config.php`  

`$items = array(
    "name" => "Sharikul Islam"
);`  

`index.php`

`include "zynamo_config.php";<br>
include "zynamo_processor.php";`