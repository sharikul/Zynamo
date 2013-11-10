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
### Documentation is slowly going to be updated!
