# Zynamo Templating Engine
Zynamo is a basic templating engine written in PHP for use in MVC type PHP projects. Zynamo allows you to store commonly used values in an array which is referenced with a key, and once a file is parsed through the Zynamo processor, it will replace those keys with their respected values. 

## How to get Zynamo
You should clone the Zynamo repository in your project folders, but it's not necessary. Wherever you want to store the Zynamo folder, simply CD (_change directory_) into that directory and run the following command from a Git terminal:

```
git clone https://github.com/sharikul/Zynamo.git
```   

After running that command, a new folder labelled 'Zynamo' should be created with the necessary files within it. 

## Begin using Zynamo
As Zynamo is primarily intended to be used in MVC style PHP projects, the following demos will assume that it's indeed being used in such a project.

### Load and instantiate the Zynamo class
Zynamo's functions come bundled in a class titled 'zynamo' (with a lowercase 'z'). **It's highly recommended that you instantiate the Zynamo class in a _core file_ (such as WordPress' _wp_load.php_) instead of the main _index.php_ file.** Zynamo was tested on BlogPad's _blog-load.php_ file, which is its core file, and here's how you would instantiate the Zynamo class from within that file:

```php
include "Zynamo/zynamo_config.php";
include "Zynamo/zynamo_processor.php";

$zynamo = new zynamo();
```

Then when `$zynamo` points to the Zynamo class, you can begin using Zynamo's processing functions with `$zynamo->name_of_function()`.

### Meet Zynamo's functions
Zynamo comes with **three** functions which handle file processing. These are:    
*  process(),
*  process_file(),
*  process_files()

Each function processes files in a unique way.  

#### `process()`  
Zynamo's `process()` function accepts one parameter - the path to an ordinary PHP or HTML file in your content directory. Once the function is run and it's able to find the intended file, it will search for indexes in the <code>{{index_name}}</code> notation. If indexes are found, it will replace them with their respective values, providing that they have been defined first in `zynamo_config.php`. On a sidenote, the values will be replaced in real time, so once you are able to see the replaced values in your browser, you should be able to see them in the file in your text editor.

#### `process_file()`
Zynamo's `process_file()` function accepts one parameter - the path to an ordinary PHP or HTML **that includes 'zynamo' in the middle of the filename, such as `index.zynamo.php`**. Unlike `process()`, this function creates the corresponding file if it doesn't already exist in the directory. For example, if `index.php` doesn't exist, once `index.zynamo.php` is parsed, `index.php` will be created. **It's worth noting that this function won't process anything unless it finds a `{{index_name}}` notation anywhere**. The `process_file()` function doesn't override a `.zynamo` file, unlike the `process()` function, thus helping with maintainability.

#### `process_files()`
If you find yourself somehow using a range of Zynamo type files, such as an ordinary PHP or HTML file with Zynamo indexes, or `.zynamo` files, it can be a long process to call `$zynamo->process()` or `$zynamo->process_file()` on all of them. This is where the `process_files()` function comes in to the rescue! The function accepts a list of files in the form of an Array or a comma separated list in a string. The function will check to see which function from `process()` to `process_file()` is the appropriate function to use to process the different files.  

Here's a demo (_in a BlogPad environment_): 
```php
$list_of_zynamo_files = array(
"$folder/index.zynamo.php",
"$folder/style.css"
);

$zynamo->process_files($list_of_zynamo_files);
``` 
_The `$folder` variable refers to BlogPad's content directory and it isn't related to Zynamo in any way._