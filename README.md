Inheritance
===========
Make multiple inheritances in PHP effortlessly, without alot of fuss and some potential headaches. **It's easy as pie, trust me!**


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
            'ClassB', 
            'ClassC'
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

## Features

- Access to protected and public methods
- Access to protected and public properties
- Throw exceptions for the use of protected properties and methods in an invalid scope
