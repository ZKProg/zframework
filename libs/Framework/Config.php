<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */


namespace Framework;

/**
 * The Config class represents the configuration parameters that the application will need, according to the desired options filled in the config files.
 * 
 * By default, the configuration files holding this information are located in the config folder, and are:
 * - config.ini
 * - routes.xml
 * - security.xml
 * 
 * This class is responsible for getting the DOMDocument of the .xml files, getting the associative array from the .ini file, as well as parsing values needed by components 
 * of the Framework.
 */
class Config {

    protected $_config_ini;
    protected $_routes_xml;
    protected $_security_xml;

    /**
     * The files used for holding the configuration are changeable. 
     * The only restrictioin is that the database must be configured in a .ini file, and the routes and security files must be in the XML format.
     *
     * @param string $init
     * @param string $routes
     * @param string $security
     */
    public function __construct($init = 'config/config.ini', 
                                $routes = "config/routes.xml", 
                                $security = 'config/security.xml') {


        $this->_routes_xml = new ConfigXMLParser($routes);      
        $this->_security_xml = new ConfigXMLParser($security);
        
        if (($this->_config_ini = \parse_ini_file($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $init, true)) === FALSE) {

            die('The ini config file could not be loaded.');
            
        }
        
    }


    /**
     * Method returning the value of the *allowed* attribute, in the *cors* tag of the *security.xml* file.
     * 
     * Returns 0 or 1 according to the policy setting in the security.xml file.
     * Returns \RuntimeException if the tag/attribute cannot be found. 
     *
     * @return mixed
     */
    public function getCORSPolicy() {

        $policy = $this->_security_xml->getNodeAttributeValue('cors', 'allowed');

        if ($policy !== false) 
            return $policy;
        else 
            throw new \RuntimeException('Bad Security Policy. Check the tag requested, and/or the config file.');

    }

    /**
     * Returns an array containing the URLs parsed in the CORS security policy .xml file.
     * Those URLs are declared allowed for cross origin resource sharing, in case cors is set to allowed in the first place.
     *
     * @return array
     */
    public function getCORSUrls() {

        $urls_array = [];
        $urls_no_space_char = [];
        $cors = $this->_security_xml->getTagNodesList('cors');

        // Go through the nodes $cors
        foreach ($cors as $node) {
            if ($node->hasAttribute('urls')) {

                // The URLs are comma separated
                $urls_array = explode(',', $node->getAttribute('urls'));
                break;

            }
        }

        // Remove spaces if any
        foreach ($urls_array as $url) {
            array_push($urls_no_space_char, str_replace(' ', '', $url));
        }

        return $urls_no_space_char;
    }

    /**
     * Returns the DOMDocument routes.xml to the Router.
     * In that case, the Router class is in charge to parse the DOMDocument.
     *
     * @return DOMDocument
     */
    public function get_routes_dom() {
        return $this->_routes_xml->get_dom_document();
    }

    /**
     * Get the value of _config_ini, i.e returns the associative array of configuration parameters found in file config.ini (used for the database connection).
     * 
     * @return array
     */ 
    public function get_config_ini()
    {
        return $this->_config_ini;
    }
}