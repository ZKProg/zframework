<?php 

namespace Framework;

class HttpResponse {

    protected $_is_cors_allowed = false;
    protected $_allowed_CORS_urls = [];

    public function __construct($allow_CORS, $allowed_CORS_urls = null) {
        
        // Define the CORS Policy (XSS)
        $this->_is_cors_allowed = $allow_CORS;
        $this->_allowed_CORS_urls = $allowed_CORS_urls;

        if ($allowed_CORS_urls !== null && $this->_is_cors_allowed === true) $this->setCORSpolicy();
    }

    public function getCookie($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    public function setNewCookie($name, $value, $expire = 0, $path = "", $domain ="", $secure = false, $http_only = false) {
        return setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);
    }

    public function setContentType($content_type) {
        header('Content-Type: ' . $content_type);
    }

    private function setCORSpolicy() {

        // TODO: Create regexes for the allowed urls.
        // TODO: Deal with spaces (remove them from the parsed config file attribute)

        ///////////////////////////////////////////////////////////////////////////////////////
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
     */ 
    public function is_cors_allowed()
    {
        return $this->_is_cors_allowed;
    }

    /**
     * Set the value of _is_cors_allowed
     *
     * @return  self
     */ 
    public function set_is_cors_allowed($_is_cors_allowed)
    {
        $this->_is_cors_allowed = $_is_cors_allowed;

        return $this;
    }
}