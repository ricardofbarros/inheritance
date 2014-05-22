<?php
include 'autoload_examples.php';

/**
 * Class A extends to ClassB, ClassC
 */
class ClassA extends \Inheritance{
    
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

/**
 * Class B
 */
class ClassB  {
    protected function hello() {
        return 'Hello';
    }
}

/**
 * Class C
 */
class ClassC {
    protected function world() {
        return 'World!';
    }
}

// Instatiate
$class = new ClassA();

// Expected Output : Hello World!
echo $class->test();
