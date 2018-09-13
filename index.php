<?php

    session_start();

    /*****************************************
     * Error reporting
     */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('BR', '<br/>');

    $authorized_routes = array(
        'localhost', '::1', 
    );

    require_once('./vendor/autoload.php');
    require_once('./libs/autoload.php');

    $autoload_index = new Autoloader('./libs', 'Framework');
    $autoload_index->register();

    $autoload_controller = new Autoloader('./src', 'Controller');
    $autoload_controller->register();

    $app = new Framework\Application;
    
    if (in_array($_SERVER['REMOTE_ADDR'], $authorized_routes)) {
        $app->launch();
    } else {
        die('You are not allowed to acces this site.');
    }
;
    
    
