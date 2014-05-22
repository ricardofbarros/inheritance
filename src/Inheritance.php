<?php
use \Inheritance\Factory\ClassFactory as ClassFactory;
use \Inheritance\Exception\NameCollisionException as NameCollisionException;
use \Inheritance\Exception\ProtectedException as ProtectedException;

class Inheritance {
    
    private $classes = array();
    
    private $list = array(
        'methods' => array(),
        'properties' => array()
    );
    
    public function __inherit ($classes) {
        // Store classes
        foreach($classes as $class) {
            // Create array-object
            $obj = ClassFactory::construct($class);

            // Store it
            $this->classes[] = $obj;
            
            // Store methods and properties of the class
            $this->list['methods'] = array_merge($this->list['methods'], $obj['methods']);
            $this->list['properties'] = array_merge($this->list['properties'], $obj['properties']);  
        } 
        try {
            $this->checkNameCollision();
        } catch (Exception $e) {
            echo 'Exception: '. $e->getMessage(). PHP_EOL;            
        }
    }
    
    private function checkNameCollision() {
        if( (count(array_unique($this->list['methods']))< count($this->list['methods'])) || 
            (count(array_unique($this->list['properties']))<count($this->list['properties'])) ) 
        {
            throw new NameCollisionException();
        }          
    }
 
    public function __call($method, $args) {
        foreach($this->classes as $class) {
            if(in_array($method, $class['methods'])) {
                $trace = debug_backtrace();
                $last = $trace[count($trace) - 1];
                $objArray = (array) $last['object'];

                try{
                    if(empty($objArray) || ($method == $last['function'])) {
                        $last['type'] = 'method';
                        $last['_class'] = $class['name'];
                        $last['method'] = $method;
                        throw new ProtectedException($last);
                    } else {
                        $method = new \ReflectionMethod($class['name'], $method);
                        $method->setAccessible(true);     
                        return $method->invokeArgs($class['object'], $args);
                    }
                } catch (ProtectedException $e) {
                    echo 'Exception: '.$e->getMessage().PHP_EOL;
                }
            }
        }   
    }
}