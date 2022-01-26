<?php
/**
 * Author: Karim Zerf
 * License: MIT.
 */
namespace Framework;

/**
 * The Service Manager is a class that creates registered services, according to what is declared in the configuration file.
 * 
 * The instances of the created services are stored in an array, that can be returned at convenience. It can also return a specific service, 
 * upon the call of a simple method.
 * 
 * The services are instantiated only once during the cycle of a full Request/Response. When a service is requested several times from a controller, 
 * the ServiceManager will:
 * 1- Return the already existing instance of the Service if the corresponding class has already been created.
 * 2- Instantiate the corresponding service class if the instance does not exist in the first place.
 * 
 * This way, we avoid creating unecessary - multiple - instances of (sometimes) memory demanding services.
 */
class ServiceManager extends LogEngine {

    protected $_config_xml;
    protected $_services_from_conf = [];
    protected $_services_names = [];
    protected $_services = [];

    /**
     * Here, the constructor takes in parameter its own config file.
     *
     * @param string $config_file
     */
    public function __construct($config_file = 'config/services.xml') {

        parent::__construct();

        $this->_config_xml = new ConfigXMLParser($config_file);
        $this->_services_from_conf = $this->_config_xml->getNodeAttributeValues('service', 'name');

        foreach ($this->_services_from_conf as $key => $name) {

            $service = new Service($name);
            array_push($this->_services, $service);

        }

    }

    /**
     * Returns the number of created services, known to the application.
     * 
     * @param void
     * @return int 
     */
    public function count_services() {
        return count($this->_services);
    }


    /**
     * Returns an array containing the *names* of the registered services. Note that we are only talking about strings here.
     * It can be useful for debugging, or backend development.
     *
     * @param void
     * @return array
     */
    public function list_services() {
        $list = [];
        foreach ($this->_services as $service) {
            array_push($list, $service->get_name());
        }

        return $list;
    }



    /**
     * Loads a service by name, as specified in the services.xml configuration file.
     * Returns the service, or throw an Exception if the service cannot be found.
     *
     * @param string $name
     * @return \Framework\Service
     */
    public function get_service($name, $args = null)
    {
        $needed_class = '\\' . ucfirst($name) . '\\' . ucfirst($name);
        $this->logMessage('Loading Service: ' . $name);

        foreach ($this->_services as $service) {

            if ($service->get_instance() instanceof $needed_class) {
                
                // The class is already created. Returns the actual instance.
                return $service->get_instance();

            } else {

                // The class doesn't exist. It is created here, and the instance is set and returned.
                
                // If no arguments array is passed (class not requiring arguments)
                if ($args === null) {

                    $class = new $needed_class();
                    $service->set_instance($class);
                
                    return $service->get_instance();
                    
                // If an argument(s) array is passed to the get_service function (for classes requiring arguments to be instantiated)
                } else {

                    $arguments_string = "";

                    if (gettype($args) == 'array') {

                        // Instantiate the class by passing the array in argument. The service class constructor is responsible 
                        // for getting the parameters out of the array.
                        $class = new $needed_class($args);
                        $service->set_instance($class);

                        return $service->get_instance();

                    } else {
                        die('Only associative arrays are allowed to be passed to the get_service function.');
                    }

                }
 
            }

        }

        // If no matching service is found, throw exception.
        throw new \RuntimeException('Call to a non existing service: ' . $service->get_name());
           
    }

}