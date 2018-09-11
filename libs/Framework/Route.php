<?php 

namespace Framework;

class Route {

    protected $_url;
    protected $_controller;
    protected $_action;

    public function __construct($url, $controller, $action) {
        
        $this->_url = $url;
        $this->_controller = $controller;
        $this->_action = $action;

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

    /**
     * Get the value of _controller
     */ 
    public function get_controller()
    {
        return $this->_controller;
    }

    /**
     * Set the value of _controller
     *
     * @return  self
     */ 
    public function set_controller($_controller)
    {
        $this->_controller = $_controller;

        return $this;
    }

    /**
     * Get the value of _action
     */ 
    public function get_action()
    {
        return $this->_action;
    }

    /**
     * Set the value of _action
     *
     * @return  self
     */ 
    public function set_action($_action)
    {
        $this->_action = $_action;

        return $this;
    }
}