<?php

namespace Controller\Entity;

class User {

    protected $_login;
    protected $_role;
    protected $last_connected;
    protected $_is_authentified;

    public function _construct() {

        
    }

    /**
     * Get the value of _login
     */ 
    public function get_login()
    {
        return $this->_login;
    }

    /**
     * Set the value of _login
     *
     * @return  self
     */ 
    public function set_login($_login)
    {
        $this->_login = $_login;

        return $this;
    }

    /**
     * Get the value of _role
     */ 
    public function get_role()
    {
        return $this->_role;
    }

    /**
     * Set the value of _role
     *
     * @return  self
     */ 
    public function set_role($_role)
    {
        $this->_role = $_role;

        return $this;
    }

    /**
     * Get the value of last_connected
     */ 
    public function getLast_connected()
    {
        return $this->last_connected;
    }

    /**
     * Set the value of last_connected
     *
     * @return  self
     */ 
    public function setLast_connected($last_connected)
    {
        $this->last_connected = $last_connected;

        return $this;
    }

    /**
     * Get the value of _is_authentified
     */ 
    public function get_is_authentified()
    {
        return $this->_is_authentified;
    }

    /**
     * Set the value of _is_authentified
     *
     * @return  self
     */ 
    public function set_is_authentified($_is_authentified)
    {
        $this->_is_authentified = $_is_authentified;

        return $this;
    }
}