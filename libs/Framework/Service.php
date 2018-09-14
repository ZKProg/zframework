<?php

namespace Framework;

class Service {

    protected $_name;
    protected $_instance;

    public function __construct($name, $instance = NULL) {

        $this->_name = $name;
        $this->_instance = $instance;

    }

    public function __destruct()
    {
        $this->_instance = NULL;
    }

    /**
     * Get the value of _name
     */ 
    public function get_name()
    {
        return $this->_name;
    }

    /**
     * Get the instance of the service (or NULL if no instance yet)
     *
     * @return mixed
     */
    public function get_instance() {
        return $this->_instance;
    }

    /**
     * Set the value of _instance
     *
     * @return  self
     */ 
    public function set_instance($_instance)
    {
        $this->_instance = $_instance;

        return $this;
    }
}