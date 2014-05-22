<?php
namespace Inheritance\Exception;

class NameCollisionException extends \Exception {
    private $property;

    public function __construct($property = null, $code = 0, $previous = null) {
        $this->property = $property;
        parent::__construct($this->format($property));

    }

    public function format($property) {
        return "I have formatted: " . $property . "!!";
    }    
}

