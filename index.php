<?php

/**
 * Author: Karim Zerf
 * Name: ZFramework
 * Version: 0.2 alpha
 * Licence: MIT
 */

    session_start();

    /*****************************************
     * Error reporting
     */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('BR', '<br/>');

    $authorized_routes = array(
        '127.0.0.1', 'localhost', '::1', 
    );

    require_once('./vendor/autoload.php');

    $app = new Framework\Application;
    
    if (in_array($_SERVER['REMOTE_ADDR'], $authorized_routes)) {
        $app->launch();
    } else {
        die('You are not allowed to acces this site.');
    }
;
    
    
