<?php
use \Inheritance\Factory\ClassFactory as ClassFactory;
use \Inheritance\Exception\NameCollisionException as NameCollisionException;
use \Inheritance\Exception\ProtectedException as ProtectedException;

/**
 * Main class of Inhertiance package, here is where all the magic
 * happens so pay attention!
 * 
 * @author Ricardo Barros <ricardofbarros@hotmail.com>
 * @copyright 2014 Ricardo Barros
 * @link https://github.com/ricardofbarros/inheritance
 * @license https://github.com/ricardofbarros/inheritance/blob/master/LICENSE
 */
class Inheritance 
{
    private $classes = array();
    
    private $list = array(
        'methods' => array(),
        'properties' => array()
    );
    
    public function __inherit ($classes) 
    {
        // Store classes
        foreach($classes as $class) {
            // Create array-object
            $obj = ClassFactory::construct($class);

            // Store it
            $this->classes[] = $obj;
            
            // Store methods and properties of the class
            $this->list['methods'] = array_merge($this->list['methods'], $obj['methods']['public'], $obj['methods']['protected']);
            $this->list['properties'] = array_merge($this->list['properties'], $obj['properties']['public'], $obj['properties']['protected']);  
        } 
        try {
            $this->checkNameCollision();
        } catch (Exception $e) {
            echo 'Exception: '. $e->getMessage(). PHP_EOL;            
        }
    }
    
    private function checkNameCollision() 
    {
        if( (count(array_unique($this->list['methods']))< count($this->list['methods'])) || 
            (count(array_unique($this->list['properties']))<count($this->list['properties'])) ) 
        {
            throw new NameCollisionException();
        }          
    }
 
    public function __call($method, $args) 
    {
        foreach($this->classes as $class) {

            // If method exists in protected scope
            if(in_array($method, $class['methods']['protected'])) {
                // Clean array
                $last = array();   
                
                // Trace back and store it
                $trace = debug_backtrace();
                $last = $trace[count($trace) - 1];
                $objArray = (array) $last['object'];
                
                // Try-catch block
                try{                   
                    // Logic to know if method was accessed in an invalid way
                    // If true throw exception
                    // If not run the method normally
                    if(empty($objArray) || ($method == $last['function'])) {
                        
                        // Info for exception
                        $last['type'] = 'method';
                        $last['_class'] = $class['name'];
                        $last['method'] = $method;
                        
                        // Throw exception
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
            // If not, check public scope
            else if(in_array($method, $class['methods']['public'])) {
                $method = new \ReflectionMethod($class['name'], $method);
                return $method->invokeArgs($class['object'], $args);                
            }
        }
        return false;
    }
    
    public function __set($name, $value) 
    {
        
    }
    
    public function __get($name) 
    {
        
    }

    public static function autoload($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $baseDir = dirname(__FILE__).DIRECTORY_SEPARATOR;
        if(file_exists($baseDir. $class.'.php')) {
            require $baseDir. $class.'.php';
        }    
    }

    public static function registerAutoloader()
    {
        spl_autoload_register("Inheritance::autoload");
    }
}