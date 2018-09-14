<?php

namespace Framework;

class ServiceManager {

    protected $_config_xml;
    protected $_services_from_conf = [];
    protected $_services_names = [];
    protected $_services = [];

    public function __construct($config_file = 'config/services.xml') {

        $this->_config_xml = new ConfigXMLParser($config_file);
        $this->_services_from_conf = $this->_config_xml->getNodeAttributeValues('service', 'name');

        foreach ($this->_services_from_conf as $key => $name) {

            $service = new Service($name);
            array_push($this->_services, $service);

        }

    }

    public function count_services() {
        return count($this->_services);
    }

    public function list_services() {
        $list = [];
        foreach ($this->_services as $service) {
            array_push($list, $service->get_name());
        }

        return $list;
    }



    /**
     * Loads a service by name, as specified in the services.xml config file.
     * Returns the service, or throw an Exception if the service cannot be found.
     *
     * @param string $name
     * @return \Framework\Service
     */
    public function get_service($name)
    {
        // TODO to move to the get service method
        $class_wanted = '\\' . ucfirst($name) . '\\' . ucfirst($name);
        

        foreach ($this->_services as $service) {

            if ($service->get_instance() instanceof $class_wanted) {
                
                // The class is already created. Returns the actual instance.
                return $this->get_instance();

            } else {

                // The class doesn't exist. It is created here, and the instance is set and returned.
                $class = new $class_wanted();
                $service->set_instance($class);
                return $service->get_instance();

            }

        }

          

        throw new \RuntimeException('Call to a non existing service: ' . $service->get_name());
           
    }

}