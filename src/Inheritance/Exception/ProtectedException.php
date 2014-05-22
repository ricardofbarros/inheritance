<?php
namespace Inheritance\Exception;

class ProtectedException extends \Exception {
    public function __construct($array = array(), $code = 0 , $prev = null) {
        parent::__construct($this->format($array));
    }

    private function format($array) {
        if($array['type'] == 'method') {
            return "Call to protected method ".$array['_class']."::".$array['method']."() from context"
                    . " '' in ".$array['file']." on line ".$array['line'];            
        } 
        else if($array['type'] == 'property') {
            
        } else {
            return "Invalid array-object on ProtectedException::_construct()";
        }
    }    
}