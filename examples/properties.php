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
       return parent::$hello.' '.parent::$world;
    }
}

/**
 * Class B
 */
class ClassB  { 
    public $helloWorld = 'This is a public Hello World!';
    
    protected $hello = 'Hello';
}

/**
 * Class C
 */
class ClassC {
    protected $world = 'World!';
}

$class = new ClassA();

// Expected Output : Hello World!
echo $class->test();

// Expected Output : This is a public Hello World!
echo $class->helloWorld;


########################################
# 
# Example 2 - Trying to access to 
# protected properties from an invalid scope
#
#########################################

// ClassA - Throws Exception
echo $class->hello.' '.$class->world;


/**
 * Class Invalid
 */
class ClassInvalid {
    public function test() {
        $class = new ClassA();
        return $class->hello.' '.$class->world; 
    } 
}

$classInvalid = new ClassInvalid();

// Throw exception
echo $classInvalid->test();


########################################
# 
# Example 3 - Grandchild inherit properties
#  from multiple grandparents
# 
#########################################

/**
 * Class Grand Child
 */
class ClassGrandChild extends ClassA {
    public function testParent() {
       return parent::hello.' '.parent::world;
    } 
}

$classGrandChild = new ClassGrandChild();

// Expected Output : Hello World!
echo $classGrandChild->testParent();