<?php
namespace Inheritance\Exception;

/**
 * Exception for name collisions on methods
 * and properties
 * 
 * @author Ricardo Barros <ricardofbarros@hotmail.com>
 * @copyright 2014 Ricardo Barros
 * @link https://github.com/ricardofbarros/inheritance
 * @license https://github.com/ricardofbarros/inheritance/blob/master/LICENSE
 */
class NameCollisionException extends \Exception 
{
    private $property;

    public function __construct($property = null, $code = 0, $previous = null) 
    {
        $this->property = $property;
        parent::__construct($this->format($property));

    }

    public function format($property) 
    {
        return "I have formatted: " . $property . "!!";
    }    
}

