<?php
namespace Inheritance\Factory;

class ClassFactory {
    public static function construct($class) {
        $instantiatedClass = self::instantiate($class);
        $methods = array();
        $properties = array();

        $reflect = new \ReflectionClass($instantiatedClass);
        $reflectedClass = array(
            'properties' => $reflect->getProperties(\ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PUBLIC),
            'methods' => $reflect->getMethods(\ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PUBLIC)
        );

        foreach($reflectedClass['properties'] as $prop) {
            $properties[] = $prop->name;
        }

        foreach($reflectedClass['methods'] as $method) {
            $methods[] = $method->name;
        }

        return array(
            'name' => $class,
            'object' => $instantiatedClass,
            'methods' => $methods,
            'properties' => $properties 
        ); 
    }
    
    private static function instantiate($class) {
        if(is_object($class)) {
            return $class;
        } else {
            return new $class();
        }   
    }
    
}
