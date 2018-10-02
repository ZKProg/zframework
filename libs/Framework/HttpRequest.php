<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */

namespace Framework;

/**
 * The HttpRequest class name speaks for itself. It represents a HTTP request, with methods that can simplify the access to some client side values.
 */
class HttpRequest {

    protected $_url;

    public function __construct() {

        $this->_url = $_SERVER['REQUEST_URI'];
        
    }

    /**
     * Get the value of _url
     * 
     * @return string _url
     */ 
    public function get_url()
    {
        return $this->_url;
    }

    /**
     * Set the value of _url
     *
     * @return  void
     */ 
    public function set_url($_url)
    {
        $this->_url = $_url;

    }
}