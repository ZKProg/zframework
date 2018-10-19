<?php 

namespace Zusers\Entity;

class User {

    protected $_login;
    protected $_first_name;
    protected $_last_name;
    protected $_email;
    protected $_hash;
    protected $_last_connection;
    protected $_created;
    protected $_role;

    public function __construct($values_array = null) {

        if (gettype($values_array) === 'array' && $values_array !== null) {

            $this->_login = $values_array['login'];
            $this->_first_name = $values_array['first_name'];
            $this->_last_name = $values_array['last_name'];
            $this->_email = $values_array['email'];
            $this->_hash = $values_array['hash'];
            $this->_last_connection = $values_array['last_connection'];
            $this->_created = $values_array['created'];
            $this->_role = $values_array['role'];

        }

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
     * Get the value of _first_name
     */ 
    public function get_first_name()
    {
        return $this->_first_name;
    }

    /**
     * Set the value of _first_name
     *
     * @return  self
     */ 
    public function set_first_name($_first_name)
    {
        $this->_first_name = $_first_name;

        return $this;
    }

    /**
     * Get the value of _last_name
     */ 
    public function get_last_name()
    {
        return $this->_last_name;
    }

    /**
     * Set the value of _last_name
     *
     * @return  self
     */ 
    public function set_last_name($_last_name)
    {
        $this->_last_name = $_last_name;

        return $this;
    }

    /**
     * Get the value of _email
     */ 
    public function get_email()
    {
        return $this->_email;
    }

    /**
     * Set the value of _email
     *
     * @return  self
     */ 
    public function set_email($_email)
    {
        $this->_email = $_email;

        return $this;
    }

    /**
     * Get the value of _hash
     */ 
    public function get_hash()
    {
        return $this->_hash;
    }

    /**
     * Set the value of _hash
     *
     * @return  self
     */ 
    public function set_hash($_hash)
    {
        $this->_hash = $_hash;

        return $this;
    }

    /**
     * Get the value of _last_connection
     */ 
    public function get_last_connection()
    {
        return $this->_last_connection;
    }

    /**
     * Set the value of _last_connection
     *
     * @return  self
     */ 
    public function set_last_connection($_last_connection)
    {
        $this->_last_connection = $_last_connection;

        return $this;
    }

    /**
     * Get the value of _created
     */ 
    public function get_created()
    {
        return $this->_created;
    }

    /**
     * Set the value of _created
     *
     * @return  self
     */ 
    public function set_created($_created)
    {
        $this->_created = $_created;

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
}