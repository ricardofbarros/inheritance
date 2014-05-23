<?php
namespace Inheritance\Factory;

/**
 * This is where classes are 'manufactured' to
 * be later extended
 * 
 * @author Ricardo Barros <ricardofbarros@hotmail.com>
 * @copyright 2014 Ricardo Barros
 * @link https://github.com/ricardofbarros/inheritance
 * @license https://github.com/ricardofbarros/inheritance/blob/master/LICENSE
 */
class ClassFactory 
{
    /**
     * Construct and return Array-Object
     * @param String $class
     * @return Array
     */
    public static function construct($class) 
    {
        // If is already an object return the object
        // If not create an instance of the object bypassing a possible
        // class constructor
        if(is_object($class)) {
           $instantiatedClass = $class;
           $class = get_class($class);
        } else {
            $instantiatedClass = self::instantiate($class);            
        }
        
        // Clean arrays
        $properties = array(
            'protected' => array(),
            'public' => array()            
        );        
        $methods = array(
            'protected' => array(),
            'public' => array()
        );
        
        // Reflection get properties and methods names (public and protected)
        $reflect = new \ReflectionClass($instantiatedClass);
        $reflectedClass = array(
            'properties' => array(
                'protected' => $reflect->getProperties(\ReflectionProperty::IS_PROTECTED),
                'public' => $reflect->getProperties(\ReflectionProperty::IS_PUBLIC)                  
            ),
            
            'methods' => array(
                'protected' => $reflect->getMethods(\ReflectionProperty::IS_PROTECTED),
                'public' => $reflect->getMethods(\ReflectionProperty::IS_PUBLIC)                  
            )
        );
        
        // Properties foreach's
        foreach($reflectedClass['properties']['protected'] as $prop) {
            $properties['protected'][] = $prop->name;
        }   
        foreach($reflectedClass['properties']['public'] as $prop) {
            $properties['public'][] = $prop->name;
        }        
        
        // Methods foreach's
        foreach($reflectedClass['methods']['protected'] as $method) {
            $methods['protected'][] = $method->name;
        } 
        foreach($reflectedClass['methods']['public'] as $method) {
            $methods['public'][] = $method->name;
        }

        // Return Array-Object
        return array(
            'name' => $class,
            'object' => $instantiatedClass,
            'methods' => $methods,
            'properties' => $properties 
        ); 
    }
    
    /**
     * Instantiate an object bypassing
     * constructor
     * 
     * @access private
     * @param String $class
     * @return Object
     */
    private static function instantiate($class) 
    {
        $reflection = new ReflectionClass($class);
        return $reflection->newInstanceWithoutConstructor(); 
    }    
}