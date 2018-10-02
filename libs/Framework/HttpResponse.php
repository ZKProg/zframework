<?php 
/**
 * Author: Karim Zerf
 * License: Mit.
 */

namespace Framework;

/**
 * The HttpResponse class name is self explanatory. Represents the response from the server to the client.
 */
class HttpResponse {

    protected $_is_cors_allowed = false;
    protected $_allowed_CORS_urls = [];

    /**
     * The constructor takes the value of the CORS policy (from the config file), and the array of allowed URLs for shared resources requests/responses.
     *
     * @param boolean $allow_CORS
     * @param array $allowed_CORS_urls
     */
    public function __construct($allow_CORS, $allowed_CORS_urls = null) {
        
        // Define the CORS Policy (XSS)
        $this->_is_cors_allowed = $allow_CORS;
        $this->_allowed_CORS_urls = $allowed_CORS_urls;

        if ($allowed_CORS_urls !== null && $this->_is_cors_allowed === true) $this->setCORSpolicy();
    }

    /**
     * Method returning the value of a cookie, by key.
     *
     * @param string $key
     * @return void
     */
    public function getCookie($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
     * Set a cookie on the client machine.
     * 
     * By default, the HTTP_Only flag is set to false, and not exclusively readable through HTTPS protocol.
     * Hence, client side javascript can access the cookie, through classic HTTP.
     *
     * @param string $name
     * @param mixed $value
     * @param integer $expire
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $http_only
     * @return boolean
     */
    public function setNewCookie($name, $value, $expire = 0, $path = "", $domain ="", $secure = false, $http_only = false) {
        return setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);
    }

    /**
     * Define the HTTP Response header Content-Type.
     *
     * @param string $content_type
     * @return void
     */
    public function setContentType($content_type) {
        header('Content-Type: ' . $content_type);
    }

    /**
     * Adds the client address to the header Access-Control-Allow-Origin, if this address belongs to the allowed ones (from configuration file).
     *
     * @return void
     */
    private function setCORSpolicy() {

        // TODO: Create regexes for the allowed urls.

        // Go through the config file urls in the cors policy node. 
        // If the client address is found and matched, the CORS header is added with this url.

        for ($i = 0; $i <= count($this->_allowed_CORS_urls); $i++) {

            if (in_array(gethostbyaddr($_SERVER['REMOTE_ADDR']), $this->_allowed_CORS_urls) || in_array($_SERVER['REMOTE_ADDR'], $this->_allowed_CORS_urls)) {
                header('Acces-Control-Allow-Origin: ' . $this->_allowed_CORS_urls[$i]);
                break;
            }

        }       
    
    }

    /**
     * Get the value of _is_cors_allowed
     * 
     * @return boolean _is_cors_allowed
     */ 
    public function is_cors_allowed()
    {
        return $this->_is_cors_allowed;
    }

    /**
     * Set the value of _is_cors_allowed
     *
     * @return void
     */ 
    public function set_is_cors_allowed($_is_cors_allowed)
    {
        $this->_is_cors_allowed = $_is_cors_allowed;
    }
}