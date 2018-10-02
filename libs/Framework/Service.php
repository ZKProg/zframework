<?php
/**
 * Author: Karim Zerf
 * License: MIT.
 */
namespace Framework;

/**
 * Class representing a Service. 
 * 
 * The services are declared in the configuration file services.xml, and instantiated when the Application class is created.
 * 
 */
class Service {

    protected $_name;
    protected $_instance;


    /**
     * The constructor takes the name of the service, and possibly an instance of an already created object.
     *
     * @param string $name
     * @param mixed $instance
     */
    public function __construct($name, $instance = NULL) {

        $this->_name = $name;
        $this->_instance = $instance;

    }

    /**
     * Free memory, if necessary.
     */
    public function __destruct()
    {
        $this->_instance = NULL;
    }

    /**
     * Get the value of _name
     * 
     * @param void
     * 
     * @return string _name
     */ 
    public function get_name()
    {
        return $this->_name;
    }

    /**
     * Get the instance of the service (or NULL if no instance yet)
     *
     * @param void
     * 
     * @return mixed
     */
    public function get_instance() {
        return $this->_instance;
    }

    /**
     * Set the value of _instance. The instance must be a Service Class instance.
     *
     * @param mixed $_instance
     * @return  self
     */ 
    public function set_instance($_instance)
    {
        $this->_instance = $_instance;

        return $this;
    }
}