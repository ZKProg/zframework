<?php 

namespace Framework;

class Config {

    protected $_config_ini;
    protected $_routes_dom;
    protected $_security_dom;

    protected $_values = [];

    public function __construct($init = 'config/config.ini', 
                                $routes = "config/routes.xml", 
                                $security = 'config/security.xml') {
        
        if (($this->_config_ini = \parse_ini_file($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $init)) === FALSE) {

            die('The ini config file could not be loaded.');
            
        }

        $this->_routes_dom = new \DOMDocument('1.0', 'utf-8');
        if ($this->_routes_dom->load($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $routes) === FALSE) {
            
            die('The routes config file could not be loaded.');
        
        }               

        $this->_security_dom = new \DOMDocument('1.0', 'utf-8');
        if ($this->_security_dom->load($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $security) === FALSE) {
            
            die('The security config file could not be loaded.');
        
        }
        
    }

    /**
     * Get the value of _routes_dom
     */ 
    public function get_routes_dom()
    {
        return $this->_routes_dom;
    }

    /**
     * Set the value of _routes_dom
     *
     * @return  self
     */ 
    public function set_routes_dom($_routes_dom)
    {
        $this->_routes_dom = $_routes_dom;

        return $this;
    }

    /**
     * Get the value of _security_dom
     */ 
    public function get_security_dom()
    {
        return $this->_security_dom;
    }

    /**
     * Set the value of _security_dom
     *
     * @return  self
     */ 
    public function set_security_dom($_security_dom)
    {
        $this->_security_dom = $_security_dom;

        return $this;
    }

    /**
     * Get the value of _config_ini
     */ 
    public function get_config_ini()
    {
        return $this->_config_ini;
    }

    /**
     * Set the value of _config_ini
     *
     * @return  self
     */ 
    public function set_config_ini($_config_ini)
    {
        $this->_config_ini = $_config_ini;

        return $this;
    }
}