# Zynamo Templating Engine
Zynamo is a very simple templating engine written in PHP. It was developed to be used to substitute commonly typed words and characters with a key which can be called in a &lt;strong&gt;PHP&lt;/strong&gt; script.  

## Start using Zynamo
To begin using Zynamo, firstly open `zynamo_config.php`. You'll find an empty array called "items". This is where you store keys linking to their value. Zynamo uses the `key =&gt; value` format, and is the format you are required to use to store keys.  

### Example
Here's a short demo showing you how to use Zynamo. In this demo, a key will be stored inside `zynamo_config.php`, and then in a new file called `index.php`, we will include `zynamo_config.php` and `zynamo_processor.php`.  

`zynamo_config.php`  

`&lt;?php

    /**
     * Config file for Zynamo. All keys must be listed in this array. 
     *
     * If the name of the array is to be changed, it must be changed also inside zynamo_processor.php.
     * 
     */


    $items = array(
        "name" =&gt; "Sharikul Islam"
    );


?&gt;`  

`index.php`  

`&lt;?php

    include "zynamo_config.php"; // Include this first!
    include "zynamo_processor.php";

?&gt;
&lt;!DOCTYPE HTML&gt;
&lt;html lang="en-GB"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;Welcome to {{name}}'s Website&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;p class="intro"&gt;Hi, my name is {{name}} and this is my website!&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
`