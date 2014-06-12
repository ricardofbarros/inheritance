<?php
namespace Inheritance\Exception;

/**
 * Exception for trying to access protected 
 * methods or properties
 * 
 * @author Ricardo Barros <ricardofbarros@hotmail.com>
 * @copyright 2014 Ricardo Barros
 * @link https://github.com/ricardofbarros/inheritance
 * @license https://github.com/ricardofbarros/inheritance/blob/master/LICENSE
 */
class ProtectedException extends \Exception 
{
    public function __construct($array = array(), $code = 0 , $prev = null) 
    {
        parent::__construct($this->format($array));
    }

    private function format($array) 
    {
        if($array['type'] == 'method') {
            return 'Call to protected method '.$array['_class'].'::'.$array['method'].'() '
                    . 'in '.$array['file'].' on line '.$array['line'];            
        } 
        else if($array['type'] == 'property') {
            return 'Call to protected property '.$array['_class'].'::'.$array['property'].' '
                    . 'in '.$array['file'].' on line '.$array['line'];                
        } else {
            return 'Invalid array-object on ProtectedException::_construct()';
        }
    }    
}