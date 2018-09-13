<?php

    // MIT License

    // Copyright (c) 2018 Karim Zerf

    // Permission is hereby granted, free of charge, to any person obtaining a copy
    // of this software and associated documentation files (the "Software"), to deal
    // in the Software without restriction, including without limitation the rights
    // to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    // copies of the Software, and to permit persons to whom the Software is
    // furnished to do so, subject to the following conditions:

    // The above copyright notice and this permission notice shall be included in all
    // copies or substantial portions of the Software.

    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    // IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    // FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    // AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    // LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    // OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    // SOFTWARE.

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
    
    
