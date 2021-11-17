<?php


require_once 'vendor/autoload.php';

#################################
## Handle Errors 
#################################
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
    case E_USER_ERROR:        
        $error_message  =  "[$errno] $errstr<br />\n";
        $error_message .=  "Fatal error on line $errline in file $errfile";
        $error_message .=  "PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $error_message .=  "Aborting...\n";
        throw new \Error($error_message, E_USER_ERROR);
        break;
    case E_USER_WARNING:
        $error_message  = "WARNING: [$errno] $errstr\n";
        throw new \Error($error_message, E_USER_WARNING);
        break;
    case E_USER_NOTICE:
        $error_message  = "NOTICE: [$errno] $errstr<br />\n";
        throw new \Error($error_message, E_USER_NOTICE);
        break;
    case E_NOTICE:
        $erro_message = "NOTICE: [$errno] $errstr<br />\n";
        //TODO -> Save Log
        break;
    default:
        $error_message  = "Unknown error type: [$errno] $errstr - File: $errfile At Line $errline";
        throw new \Error($error_message);
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}
set_error_handler("myErrorHandler");

