<?php
// Autoloader for examples
function autoload_examples($class) {
    $path = '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR;
    if(file_exists($path.$class.'.php')) {
        include $path.$class.'.php';
    } else{
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        if(file_exists($path.$class.'.php')) {
            include $path.$class.'.php';
        } 
    }
}

spl_autoload_register('autoload_examples');