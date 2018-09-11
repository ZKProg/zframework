<?php 

namespace Framework;

class HttpRequest {

    protected $_url;

    public function __construct() {

        $this->_url = $_SERVER['REQUEST_URI'];
        
    }

    /**
     * Get the value of _url
     */ 
    public function get_url()
    {
        return $this->_url;
    }

    /**
     * Set the value of _url
     *
     * @return  self
     */ 
    public function set_url($_url)
    {
        $this->_url = $_url;

        return $this;
    }
}