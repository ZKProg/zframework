<?php

namespace Framework;

class ServiceManager {

    protected $_config_xml;
    protected $_services = [];

    public function __construct($config_file = 'config/services.xml') {

        $this->_config_xml = new ConfigXMLParser($config_file);

        $this->_services = $this->_config_xml->getNodeAttributeValues('service', 'name');

    }

    /**
     * Get the value of _services
     */ 
    public function get_services()
    {
        return $this->_services;
    }
}