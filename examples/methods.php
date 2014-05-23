<?php
define('DS', DIRECTORY_SEPARATOR);
include '..'.DS.'src'.DS.'Inheritance.php';

// Register auto loader
Inheritance::registerAutoloader();

#############################
# 
# Example 1 - Extending Class
#
#############################

/**
 * Class A extends to ClassB, ClassC
 */
class ClassA extends \Inheritance{
    
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

/**
 * Class B
 */
class ClassB  {
    public function helloWorld() {
        return 'This is a public Hello World!';
    }
    
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

$class = new ClassA();

// Expected Output : Hello World!
echo $class->test();

// Expected Output : This is a public Hello World!
echo $class->helloWorld();


########################################
# 
# Example 2 - Trying to access to 
# protected methods from an invalid scope
#
#########################################

// ClassA - Throws Exception
echo $class->hello().' '.$class->world();


/**
 * Class Invalid
 */
class ClassInvalid {
    public function test() {
        $class = new ClassA();
        return $class->hello().' '.$class->world(); 
    } 
}

$classInvalid = new ClassInvalid();

// Throw exception
echo $classInvalid->test();



########################################
# 
# Example 3 - Grandchild inherit methods
#  from multiple grandparents
# 
#########################################

/**
 * Class Grand Child
 */
class ClassGrandChild extends ClassA {
    public function testParent() {
       return parent::hello().' '.parent::world();
    } 
}

$classGrandChild = new ClassGrandChild();

// Expected Output : Hello World!
echo $classGrandChild->testParent();