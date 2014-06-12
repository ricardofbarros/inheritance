Inheritance
===========
Make multiple inheritances in PHP effortlessly, without alot of fuss and some potential headaches. **It's easy as pie, trust me!**

## How does this work?

Well it's simple, when you extend 'Inheritance' to your main class (child), you will gain a new method '__inherit', this method will accept an 
array with objects or the name of your classes, see To construct or not to construct for further understanding, next it will store all non-static 
public and protected methods and properties using Reflection. 

For example, when you call a method it will trigger 'Inheritance' magic method '__call', and if this method exists in any class inherited, it will invoke this
method.

Inheritances uses the following magic methods '__call', '__set', '__get'


## Installation

### Composer Install
Just follow these simple steps to install Inheritance in your project:

1. Get [Composer](http://getcomposer.org)

2. Run this command to install Inheritance in your project dir

```bash
composer require ricardofbarros/inheritance:dev-master
```

3. Start inheriting stuff right away

```php
class ClassA extends \Inheritance {

...

}
```

### Manual Install
Download and extract the Inheritance package into your project directory and require it and register Inheritance autoloader in your application’s bootstrap file.

```php
require "path/to/inheritance/src/Inheritance.php"

Inheritance::registerAutoloader();
```

## Basic Usage

```php
## ClassA.php
class ClassA extends \Inheritance {

    public function __construct() {
        parent::__inherit(array(
            new ClassB(), 
            new ClassC()
         ));
    }
    
    public function test() {
       return parent::hello().' '.parent::world();
    }    
}

## ClassB.php
class ClassB  {
    protected function hello() {
        return 'Hello';
    }
}


## ClassC.php
class ClassC {
    protected function world() {
        return 'World!';
    }
}

## somefile.php
$class = new ClassA();

// Output : Hello World!
echo $class->test();
```

> **NOTE:** For some more usage examples, see files in `examples` dir

## To construct or not to construct?

You can decide if you want to construct a class or just bypass the '__constructor', it's very simple to do that
just see the example bellow.

```php
class ClassA extends \Inheritance {

    public function __construct() {
        parent::__inherit(array(
            'ClassB', // This will instance the class bypassing a potential existence of a constructor
            new ClassC() // This will call __construct() as expected
         ));
    }
    
    public function test() {
       return parent::hello().' '.parent::world();
    }    
}
```

## Features

- Access to protected and public methods
- Access to protected and public properties
- Throw exceptions for the use of protected properties and methods in an invalid scope
- Decide which classes inherited you want to construct or instantiate without constructing