<?php

    namespace Framework;

    class Application {

        protected $_render_template = null;
        protected $_httpRequest;
        protected $_httpResponse;
        protected $_logEngine;
        protected $_router;
        protected $_config;
        public $_conn, $_db;

        public function __construct() {

            /////////////////////////////////////////////////////////////////////
            // TWIG Setup
            /////////////////////////////////////////////////////////////////////
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../templates');

            $this->_render_template = new \Twig_Environment($loader, array(
                // 'cache' => __DIR__ . '/../../templates/cache',
                'cache' => false,
            ));

            //////////////////////////////////////////////////////////////////////
            // INIT main components of the application
            $this->_httpRequest = new HttpRequest;
            $this->_logEngine = new LogEngine;
            $this->_config = new Config;    
            $this->_httpResponse = new HttpResponse($this->_config->getCORSPolicy(), $this->_config->getCORSUrls());
            $this->_router = new Router($this->_config->get_routes_dom());        
            $this->_conn = new DBConnection($this->_config->get_config_ini());
            $this->_db = $this->_conn->getMySQLConnection();
            
        }

        public function launch() {


            // 1 Get the route from the router (first route found matching)
            if (($route = $this->_router->getMatchedRoute($this->_httpRequest->get_url())) !== false) {
                // Matching route found

                // 2 Instantiate the right controller according to the route
                // Instance $this passed by reference to the controller.
                $controller_to_call = '\\Controller\\' . ucfirst($route->get_controller()) . 'Controller';

                $controller = new $controller_to_call($this);

                // 3 We execute the relevant action
                $action_to_call = ucfirst($route->get_action()) . 'Action';
                $controller->$action_to_call();

            } else {

                // 404
                $not_found = $this->_render_template->load('404.twig.html');
                echo $not_found->render();
                header('HTTP/1.0 404 Not Found');
                die();
               
            }
        
        }

        /**
         * Get the value of _config
         */ 
        public function get_config()
        {
                return $this->_config;
        }

        /**
         * Get the value of _router
         */ 
        public function get_router()
        {
                return $this->_router;
        }

        /**
         * Get the value of _logEngine
         */ 
        public function get_logEngine()
        {
                return $this->_logEngine;
        }

        /**
         * Get the value of _httpResponse
         */ 
        public function get_httpResponse()
        {
                return $this->_httpResponse;
        }

        /**
         * Get the value of _httpRequest
         */ 
        public function get_httpRequest()
        {
                return $this->_httpRequest;
        }

        /**
         * Get the value of _render_template
         */ 
        public function get_render_template()
        {
                return $this->_render_template;
        }

        /**
         * Get the value of _db
         */ 
        public function get_db()
        {             
                return $this->_db;
        }
    }