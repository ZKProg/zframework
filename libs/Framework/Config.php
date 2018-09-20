<?php 

namespace Framework;

class Config {

    protected $_config_ini;
    protected $_routes_xml;
    protected $_security_xml;

    public function __construct($init = 'config/config.ini', 
                                $routes = "config/routes.xml", 
                                $security = 'config/security.xml') {


        $this->_routes_xml = new ConfigXMLParser($routes);      
        $this->_security_xml = new ConfigXMLParser($security);
        
        if (($this->_config_ini = \parse_ini_file($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $init, true)) === FALSE) {

            die('The ini config file could not be loaded.');
            
        }
        
    }

    public function getCORSPolicy() {

        $policy = $this->_security_xml->getNodeAttributeValue('cors', 'allowed');

        if ($policy !== false) 
            return $policy;
        else 
            throw new \RuntimeException('Bad Security Policy. Check the tag requested, or the config file.');

    }

    /**
     * Returns an array containing the URLs parsed in the CORS security policy .xml file.
     * Those URLs are declared allowed for CORS.
     *
     * @return array
     */
    public function getCORSUrls() {

        $urls_array = [];
        $urls_no_space_char = [];
        $cors = $this->_security_xml->getTagNodesList('cors');

        foreach ($cors as $node) {
            if ($node->hasAttribute('urls')) {

                $urls_array = explode(',', $node->getAttribute('urls'));
                break;

            }
        }

        // Remove spaces
        foreach ($urls_array as $url) {
            array_push($urls_no_space_char, str_replace(' ', '', $url));
        }

        return $urls_no_space_char;
    }

    /**
     * Returns the DOMDocument routes.xml to the Router.
     * In that case, the Router class is in charge to parse the DOMDocument.
     *
     * @return \DOMDocument
     */
    public function get_routes_dom() {
        return $this->_routes_xml->get_dom_document();
    }

    /**
     * Get the value of _config_ini
     */ 
    public function get_config_ini()
    {
        return $this->_config_ini;
    }
}