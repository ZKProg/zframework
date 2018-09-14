<?php

class Autoloader {

    protected $_file_extension = '.php';
    protected $_namespace = null;
    protected $_namespace_separator = '\\';
    protected $_include_path = null;

    /**
     * Creates an autoloader for the framework
     * @param None
     * @return Object
     */
    public function __construct($includepath, $namespace) {
        $this->_include_path = $includepath;
        $this->_namespace = $namespace;
    }

    public function register() {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function unregister($class) {
        spl_autoload_unregister($class);
    }

    protected function loadClass($classname) {
               
        $include_os_path = str_replace($this->_namespace_separator !== '\\' ? '\\' : '/', DIRECTORY_SEPARATOR, $this->_include_path);
        $total_include_os_path = $include_os_path . DIRECTORY_SEPARATOR . $classname;

        $file_name = $total_include_os_path . $this->_file_extension;
        $absolute_file_name = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $file_name;

        if (file_exists($absolute_file_name)) require_once($absolute_file_name);
          
    }

    /******************************************************
     * GETTERS SETTERS
     */

    /**
     * Get the value of _file_extension
     */ 
    public function get_file_extension()
    {
        return $this->_file_extension;
    }

    /**
     * Set the value of _file_extension
     *
     * @return  self
     */ 
    public function set_file_extension($_file_extension)
    {
        $this->_file_extension = $_file_extension;

        return $this;
    }

    /**
     * Get the value of _namespace
     */ 
    public function get_namespace()
    {
        return $this->_namespace;
    }

    /**
     * Set the value of _namespace
     *
     * @return  self
     */ 
    public function set_namespace($_namespace)
    {
        $this->_namespace = $_namespace;

        return $this;
    }

    /**
     * Get the value of _namespace_separator
     */ 
    public function get_namespace_separator()
    {
        return $this->_namespace_separator;
    }

    /**
     * Set the value of _namespace_separator
     *
     * @return  self
     */ 
    public function set_namespace_separator($_namespace_separator)
    {
        $this->_namespace_separator = $_namespace_separator;

        return $this;
    }

    /**
     * Get the value of _include_path
     */ 
    public function get_include_path()
    {
        return $this->_include_path;
    }

    /**
     * Set the value of _include_path
     *
     * @return  self
     */ 
    public function set_include_path($_include_path)
    {
        $this->_include_path = $_include_path;

        return $this;
    }
}