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
### Documentation is slowly going to be updated!
