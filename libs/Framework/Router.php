<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */

namespace Framework;

/**
 * The Router is the part of the Application that deals with the routes/routing during the management of a request.
 * It holds all the *routes* defined in the configuration files, and is able to determine - according to the actual URL requested, what
 * controller should be instantiated, and what action (method) of that very controller should be called.
 * 
 * The behavior is defined as it will always return the *FIRST* matching route found, versus the order in which routes have been defined in 
 * the corresponding (routes.xml) configuration file.
 */
class Router {

    protected $_routes = [];

    /**
     * The constructor takes the DOMDocument from the routes.xml configuration file.
     *
     * @param \DOMDocument $routes_dom_doc
     */
    public function __construct(\DOMDocument $routes_dom_doc) {
        

            $routes = $routes_dom_doc->getElementsByTagName('route');

            foreach ($routes as $key => $route) {

                if ($route->hasAttribute('url') && $route->hasAttribute('controller') && $route->hasAttribute('action')) {

                    $new_route = new Route(
                        $route->getAttribute('url'),
                        $route->getAttribute('controller'),
                        $route->getAttribute('action')
                    );

                    // Check if the route has variables
                    if ($route->hasAttribute('vars')) {

                        $variables_array = explode(',', str_replace(' ', '', $route->getAttribute('vars')));
                        $new_route->set_vars($variables_array);

                    }

                    array_push($this->_routes, $new_route);

                } else {
                    die('One of the routes is not configured correctly.');
                }
            }
    }

    /**
     * TODO: Check if this is necessary in PHP.
     * Double check the memory is cleaned, as the route array can be large.
     */
    public function __destruct()
    {
        $this->_routes = NULL;
    }

    /**
     * Checks if a given URL is matching the one from a given Route.
     * 
     * Returns true in such a case.
     *
     * @param string $url
     * @param Route $route
     * @return boolean
     */
    public function isRouteMatching($url, Route $route) {

        if (preg_match('~^' . $url . '~$', $route->get_url())) return true;

        return false;
    }

    /**
     * Goes through the array containing all the registered routes. It returns, if it exists, the route that matches the given URL.
     * 
     * Returns false if no route is matching the url passed as argument.
     * 
     * @param string $url
     * @return Mixed
     */
    public function getMatchedRoute($url) {

        foreach ($this->_routes as $key => $route) {

            if (preg_match('~^' . $route->get_url() . '~', $url, $matches)) {
                
                // TODO: Rename the method and attribute _url_regex_elements with a more relevant name (code refactoring)
                $vars = [];
                $route_vars = $route->get_vars();

                if ($route->hasVars()) {
                    
                    foreach ($matches as $key => $value) {      
                                      
                        if ($key !== 0) { // preg_match behavior. The first array value is the full string pattern of the regex.
                            
                            $vars[$route_vars[$key-1]] =  htmlspecialchars($value);

                        }
                    }

                    $route->set_url_regex_elements($vars);
                }

                return $route;
            }
        }

        return false;
    }


    /**
     * Returns the array containing all the routes registered in the configuration file.
     * 
     * @param void
     * 
     * @return array _routes
     */ 
    public function get_routes()
    {
        return $this->_routes;
    }
}