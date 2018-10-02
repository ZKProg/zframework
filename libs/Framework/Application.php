<?php

/**
 * Author: Karim Zerf
 * License MIT.
 */
    namespace Framework;

    /**
     * The Application class is the heart of the framework. This is the class created when a request is received by the server, that contains
     * all the useful instances to serve the response to the client. It includes instances of classes that represent the HTTP Request and Response,
     * a rendering template engine (TWIG by default), a router, the config of the framework itself and a light weight service manager. It inherits a log engine, so as 
     * custom messages can be logged from within the controllers of the framework, by the programmer/developper.
     */
    class Application extends LogEngine {

        protected $_render_template = null;
        protected $_httpRequest;
        protected $_httpResponse;
        protected $_logEngine;
        protected $_router;
        protected $_config;
        protected $_conn, $_db;
        protected $_mailer;
        protected $_service_manager;

        /**
         * Application constructor
         * 
         * This constructor does several things for the framework, providing for features that can be used later in the controllers, among with
         * setting up the applicaton itself.
         * 
         * The TWIG template engine is created and set up here. By default, the templating folders are:
         * - ${framework_root}/templates
         * - ${framework_root}/templates/cache 
         * 
         * The HTTPRequest, Config, and ServiceManager classes are instantiated without passing any paramaters to the constructors.
         * 
         * As opposed as:
         * - The HTTPResponse class: this class needs access to the _config object, in order to get the paramaters the constructor needs, which are 1- The Cross-Origin Resource Sharing 
         *   policy (whether or not the Application will accept cross origins resources) and the corresponding list of URLs that would be accepted if such a policy is accepted.
         *   Those parameters are to be set in the config file, inside the config folder at the root of the framework.
         * - The Router class: the constructor of this class expects to receive a DOMDocument class, holding the XML Config file. 
         * - The DBConnection class: this class constructor needs to get the config .ini file, corresponding to the credentials and information of the database to be connected by the application.   
         * 
         * Finally, when the DBConnection has been created, this application gets the PDO, held as an attribute of the class.
         */
        public function __construct() {

                // Construction of LogEngine
                parent::__construct();
                
                // TWIG Setup  
                $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../templates');

                $this->_render_template = new \Twig_Environment($loader, array(
                        // 'cache' => __DIR__ . '/../../templates/cache',
                        'cache' => false,
                ));

                
                // INIT main components of the application
                $this->_httpRequest = new HttpRequest;
                $this->_config = new Config;    
                $this->_httpResponse = new HttpResponse($this->_config->getCORSPolicy(), $this->_config->getCORSUrls());
                $this->_router = new Router($this->_config->get_routes_dom());        
                $this->_conn = new DBConnection($this->_config->get_config_ini());
                $this->_db = $this->_conn->getMySQLConnection();
                $this->_service_manager = new ServiceManager();   

            
        }

        /**
         * Method actually launching the Application, starting the process of eventually sending a HTTP Response to the client.
         * 
         * This is when this method is called that the router will try:
         * - To find the actual requested URL, and match it with a known route (from the routes.xml config file).
         * - To create the relevant controller (coupling the controller/action paradigm) to the *first* matching route found by the router.
         * 
         * In the situation where the router cannot find any matching route, the Application will render and return the default 404 template. 
         *
         * @return void
         */
        public function launch() {


            // 1 Get the route from the router (first route found matching)
            if (($route = $this->_router->getMatchedRoute($this->_httpRequest->get_url())) !== false) {
                
                // ---------------------Matching route has been found-------------------------------------

                // 2 Instantiate the right controller according to the route
                // Instance $this passed by reference to the controller.
                $controller_to_call = '\\Controller\\' . ucfirst($route->get_controller()) . 'Controller';

                $controller = new $controller_to_call($this);

                // 3 Execute the relevant action (call the corresponding method from the controller just created)
                $action_to_call = ucfirst($route->get_action()) . 'Action';
                $controller->$action_to_call();

            } else {

                //--------------------- No matching route has been found-----------------------------------

                // Returns and render 404 (both HTTP Header and HTML template)
                $not_found = $this->_render_template->load('404.twig.html');
                echo $not_found->render();
                header('HTTP/1.0 404 Not Found');
                die();
               
            }
        
        }

        /**
         * Get the value of _config
         * 
         * @return Config
         */ 
        public function get_config()
        {
                return $this->_config;
        }

        /**
         * Get the value of _router
         * 
         * @return Router
         */ 
        public function get_router()
        {
                return $this->_router;
        }

        /**
         * Get the value of _logEngine
         * 
         * @return LogEngine
         */ 
        public function get_logEngine()
        {
                return $this->_logEngine;
        }

        /**
         * Get the value of _httpResponse
         * 
         * @return HTTPResponse
         */ 
        public function get_httpResponse()
        {
                return $this->_httpResponse;
        }

        /**
         * Get the value of _httpRequest
         * 
         * @return HTTPRequest
         */ 
        public function get_httpRequest()
        {
                return $this->_httpRequest;
        }

        /**
         * Get the value of _render_template
         * 
         * @return Twig_Environment 
         */ 
        public function get_render_template()
        {
                return $this->_render_template;
        }

        /**
         * Get the value of _db
         * 
         * @return PDO
         */ 
        public function get_db()
        {             
                return $this->_db;
        }

        /**
         * Get the service manager
         * 
         * @return ServiceManager
         */
        public function get_service_manager() {
                return $this->_service_manager;
        }
    }