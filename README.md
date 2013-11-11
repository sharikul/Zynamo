# Zynamo PHP
Zynamo is a PHP based templating engine. Its syntax is almost that of a fully featured programming language. 

As such, Zynamo allows you to write PHP in a different way to the norm. However, Zynamo PHP only introduces its new syntax into areas of PHP that are likely to be widely used throughout PHP scripts, such as `if`'s, `echo`'s, and others.

The following Zynamo PHP code:
```php 
$capital_city = 'London' if $country is 'United Kingdom' else 'Paris';
```
Will convert into:
```php
$capital_city = ( $country === 'United Kingdom' ) ? 'London': 'Paris';
```

## Loading and processing templates
Before you begin to use Zynamo, it's vital that you create and load a template. A Zynamo template can end in the `.zy` or `.tl` file extensions. Then, create a `.php` file that you will use to load the Zynamo class. Require the Zynamo class by specifying the path to `Zynamo.php` within the Zynamo directory, then instantiate the Zynamo class. You can provide the path to a template while instantiating, or call the `render` method after instantiating.

### Example:

#### `index.zy`
```html
<p>I'm within index.zy</p>
```

#### `index.php`
```php
require 'path/to/Zynamo/Zynamo.php';

$zynamo = new Zynamo('index'); // You can leave off the file extension if the extension of the template is .zy

// or

$zynamo->render('index');
```

Browse to the PHP file in your browser and your template should be compiled. Compiled templates are stored in the `compiled/` directory within the Zynamo directory.

## Writing Zynamo code in templates
Likewise to PHP's `<?php` and `?>` tags, Zynamo uses its own sets of tags, `[[` (_opening tag_) and `]]` (_closing tag_), that it uses to search for Zynamo code. In templates, any Zynamo specific code should be written between the two square bracket tags. Writing Zynamo code within PHP tags will result in parse errors.

### Example:

#### `index.zy`
```php
[[
  $title = 'Page Title' if !isset( $title );
]]
<html>
  <head>
    <title>[[ echo $title; ]]</title>
  </head>
  <body>
    <ul>
      [[
        for( 1...50 using $counter) {
          echo '<li>List {$counter}</li>';
        }
      ]]
    </ul>
  </body>
</html>
```

#### `index.php` - compiled template
```php
<?php
  if( !isset( $title ) ) {
    $title = 'Page Title';
  }
?>
<html>
  <head>
    <title><?php echo $title; ?></title>
  </head>
  <body>
    <ul>
      <?php
        for( $counter = 1; $counter <= 50; ++$counter) {
          echo '<li>List '.$counter.'</li>';
        }
      ?>
    </ul>
  </body>
</html>
```
## Defining functions
Functions in PHP are as simple as they can get. With PHP 5, you can also type hint function parameters so that the compiler can conduct strict checking on parameters. However, there's currently no support for the `string`, `int`, and `bool` types. Functions in Zynamo PHP introduce support for these types, generating polyfill code at compile time:

The following Zynamo PHP code:
```php
function revealInfo( String $name, Int $age = 18, Boolean $student = true) {
echo "You are an $age year old student $name" if $student;
}
```

Will convert into:
```php
function revealInfo($name, $age = 18, $student = true) {
$student = ( is_bool( $student ) ) ? $student: trigger_error( ... );

$age = ( is_int( $age ) ) ? $age: trigger_error( ... );

$name = ( is_string( $name ) ) ? $name: trigger_error( ... );

if( $student ) {
  echo "You are an $age year old student $name";
}
}
```

You can also define a function via the `def` keyword, instead of `function`, if you'd like.

## Defining constants
Constants in Zynamo PHP are identified as not starting with a dollar symbol, which denotes a variable. Therefore the following Zynamo code:
```php
isConstant = true;
```

Will convert into:
```php
define('isConstant', true);
```

Simple!

## Creating arrays
Arrays in Zynamo PHP are designed to almost replicate the JavaScript style of creating arrays. In Zynamo PHP, you aren't required to quote array keys, or use the `=>` symbol to link keys to values. A Zynamo PHP array starts with the `[` bracket and ends with the `]` bracket. Likewise to PHP 5.4, arrays must be terminated with a semicolon.

Zynamo PHP array:
```php
$myArray = [
  name: 'Sharikul Islam',
  age: 18,
  location: 'London, United Kingdom',
  additionalInfo: [
    driver: false,
    student: true,
    birthMonth: 'November',
    birthYear: 1995
  ]
];
```

Will convert into:
```php
$myArray = array(
  "name" => 'Sharikul Islam',
  "age" => 18,
  "location" => 'London, United Kingdom',
  "additionalInfo" => array(
    "driver" => false,
    "student" => true,
    "birthMonth" => 'November',
    "birthYear" => 1995
   )
);
```
You can also provide an array list (one that doesn't link values to key), like so:
```php
$requiredKeys = [name, age, location];
```
Which will compile into:
```php
$requiredKeys = array("name", "age", "location");
```
### Some tips on using this feature
**Consistency is key**. As of yet, you cannot supply key value pairs in an array that has started off with taking just keys on their own. This will lead to Zynamo to ignore the keys on their own, which will lead PHP to treat the other keys as constants. Therefore as shown in the examples above, supply key value pairs into an array that is already taking key value pairs, and just supply keys on their own into an array that is taking just keys.

Additionally, you can't yet supply a Zynamo PHP shorthand array as a function parameter. To get around this, you should reference an array via a variable and use the variable instead as a function parameter.


## Accessing array keys
Zynamo PHP still allows you to use the default PHP array access notation (`$variable_to_array['array']['nestedArray']`). However, Zynamo PHP introduces a dotted access notation, which is similar to JavaScript.

This Zynamo PHP notation corresponding to the array created in the previous example:
```php
echo $myArray.additionalInfo.birthMonth;
```

Will convert into:
```php
echo $myArray['additionalInfo']['birthMonth'];
```

## Comments
In Zynamo PHP, you can still make use of PHP's various commenting methods (either `/* comment */` or `// comment`). However, since Zynamo PHP is Regex powered, any example code provided with PHP comment methods are likely to be interpreted as regular code, which can cause unexpected problems. Therefore Zynamo PHP introduces its own style of commenting, via the hash (`#`) symbol on each side.

Zynamo PHP comment:
```php
# I am a comment. Look! I'm accessing $myArray.location! constant = false; #
```

Converts into:
```php
/* I am a comment. Look! I'm accessing $myArray.location! constant = false; */
```

That's it!

## Inline `if`'s and `unless`'s
Zynamo PHP allows you to write conditional `if` statements inline, similar to JavaScript, as well as **one** `else` statement. An `unless` statement is a shorthand method of executing code whilst a condition returns `false`. Conditions of statements **must not be written between brackets**.

### Examples
Zynamo PHP:
```php
$student = true if $myArray.age is 18 else false;
```

PHP:
```php
$student = ( $myArray['age'] === 18 ) ? true: false;
```

Zynamo PHP:
```php
echo 'Hello, Sharikul!' if $myArray.name is 'Sharikul' else 'Hello, stranger!';
```

PHP:
```php
echo ( $myArray['name'] === 'Sharikul' ) ? 'Hello, Sharikul!': 'Hello, stranger!';
```

Zynamo PHP:
```php
$name = 'Web Developer' unless $myArray.name is 'Sharikul';
```

PHP:
```php
if( !( $myArray['name'] === 'Sharikul') ) {
  $name = 'Web Developer';
}
```
## Human operators
Human operators refer to certain English based keywords which convert into the PHP equivalent. Zynamo PHP allows these human operators to be used in Zynamo code:

#### `is`
Converts into: `===`

Example:
```php
// Zynamo PHP
if( 1 is 1 ) {
  echo 'I knew it!';
}

// Normal PHP
if( 1 === 1 ) {
  echo 'I knew it!';
}
```
#### `isnt`
Converts into: `!==`

Example:
```php
// Zynamo PHP
if( 2 isnt 1 ) {
  echo 'I knew that.';
}

// Normal PHP
if( 2 !== 1 ) {
  echo 'I knew that.';
}
```
#### `lowerthan` or `lt`  
Converts into: `<`

Example:
```php
// Zynamo PHP
if( 5 lt 10 ) {
  echo '5 is lower than 10!';
}

// Normal PHP
if( 5 < 10 ) {
  echo '5 is lower than 10!';
}
```
#### `lowerequal` or `lte`
Converts into: `<=`

Example:
```php
$number = 10;
// Zynamo PHP
if( $number lte 10 ) {
  echo 'Got the same number';
}

// Normal PHP
if( $number <= 10 ) {
  echo 'Got the same number';
}
```
#### `greaterthan` or `gt`
Converts into `>`

Example:
```php
$number = 10;
// Zynamo PHP
if( $number gt 5 ) {
  echo "$number is greater than 5!";
}

// Normal PHP
if( $number > 5 ) {
  echo "$number is greater than 5!";
}
```
#### `greaterequal` or `gte`
Converts into `>=`

Example:
```php
$number = 50;
// Zynamo PHP
if( $number gte 50 ) {
  echo "$number is greater or equal to 50!";
}

// Normal PHP
if( $number >= 50 ) {
  echo "$number is greater or equal to 50!";
}
```
## Interpolation
Zynamo PHP allows you to interpolate values within **single quoted strings**. Interpolation within single quoted strings is denoted via the opening `{` bracket and the closing `}` bracket. After compilation, the values interpolated will be concatenated to form a string, as you'd expect. You can interpolate anything, from functions to constants and variables. **But do use this feature _wisely_.**

Zynamo PHP:
```php
echo 'Hello, my name is {$myArray.name}. I am {$myArray.age} years old from {$myArray.location}!';
```

PHP:
```php
echo 'Hello, my name is '.$myArray['name'].'. I am '.$myArray['age'].' years old from '.$myArray['location'].'!';
```

### Some tips on how to use this feature
Whilst you are allowed to interpolate anything, including functions, if you are someone who provides parameters in single quotes, you can run into issues with PHP after Zynamo has compiled your code. If providing parameters to functions within interpolation brackets, always make use of **double quotes**!

If you'll need to provide square brackets that should be displayed as normal in single quotation texts, always escape the opening bracket `{` by `\{`, and Zynamo will ignore it.
 
## `unless` blocks
Unique to Zynamo PHP, you can also write code within an `unless` block. The structure is the same as other language structures such as the `if` structure.

Zynamo PHP:
```php
unless( 5 > 10 ) {
  echo '5 is lower than 10!';
} else {
  echo 'You will never see me!';
}
```

PHP:
```php
if( !( 5 > 10 ) ) {
  echo '5 is lower than 10!';
} else {
  echo 'You will never see me!';
}
```
You can make use of Zynamo's "human operators" within the condition brackets, just like you would within any other structure.

## `for` looping
In Zynamo PHP, the `for` loop structure has been redesigned. The Zynamo PHP `for` structure is designed to be contextually easy to read and understand. 

### Examples:
Zynamo PHP:
```php
for( 1...50 using $position ) {
echo 'We are currently at {$position}!';
}
```
PHP:
```php
for( $position = 1; $position <= 50; ++$position ) {
  echo 'We are currently at '.$position.'!';
}
```
If the first number that is provided is greater in value than that of the second number, Zynamo PHP will automatically change the looping structure.

Zynamo PHP:
```php
for( 250...10 using $position) {
  echo 'Counting down from 250, we are currently at {$position}.';
} 
```
PHP:
```php
for( $position = 250; $position >= 10; --$position) {
  echo 'Counting down from 250, we are currently at '.$position.'.';
}
```
#### The `using` keyword
The `using` keyword lets you provide a variable that will act as a reference to the loop counter, as you can see in the examples above. If you don't provide this keyword, the default variable that will be used instead is `$i`. 

#### Significance of the dots
From the examples provided above, you would see that they've used `...`. In Zynamo PHP, this is used to denote `<=` or `>=`. Providing two dots (`..`) denotes `<` or `>`. **That's it!**

### `foreach` looping
You can run a `foreach` loop through the Zynamo PHP `for` structure.

Zynamo PHP:
```php
$ages = [
  firstPerson: 50,
  secondPerson: 40,
  thirdPerson: 30,
  fourthPerson: 20
];

for( $name, $age in $ages ) {
  echo '{$name}\'s age is {$age}<br>';
}
```

PHP:
```php
$ages = array(
  "firstPerson" => 50,
  "secondPerson" => 40,
  "thirdPerson" => 30,
  "fourthPerson" => 20
);

foreach( $ages as $name => $age ) {
  echo ''.$name.'\'s age is '.$age.'<br>';
}
```

As with everything else, you can resort to normal PHP if you'd like in Zynamo PHP.
### Documentation is slowly going to be updated!
