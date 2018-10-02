<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */

namespace Framework;

/**
 * Class representing a single route. A route is a symbolic representation of what controller must be created, and what 
 * method from that controller must be called. 
 * 
 * The routes are defined in the routes.xml configuration file.
 */
class Route {

    protected $_url;
    protected $_controller;
    protected $_action;

    /**
     * The constructor takes three parameters, that define in turn a route.
     *
     * @param string $url
     * @param string $controller
     * @param string $action
     */
    public function __construct($url, $controller, $action) {
        
        $this->_url = $url;
        $this->_controller = $controller;
        $this->_action = $action;

    }

    /**
     * Get the value of _url
     * 
     * @param void
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
     * @param string $_url
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
     * 
     * @param void
     * 
     * @return string _controller
     */ 
    public function get_controller()
    {
        return $this->_controller;
    }

    /**
     * Set the value of _controller
     * 
     * @param string $_controller
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
     * 
     * @param void
     * 
     * @return string _action
     */ 
    public function get_action()
    {
        return $this->_action;
    }

    /**
     * Set the value of _action
     * 
     * @param string $_action
     *
     * @return  self
     */ 
    public function set_action($_action)
    {
        $this->_action = $_action;

        return $this;
    }
}