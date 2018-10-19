<?php 

namespace Controller;

use \Framework\Application;

class HomeController {

    protected $_app = null;
    protected $_url_regex_elements;

    public function __construct(Application &$app, $url_regex_elements = []) {

        $this->_app = $app;
        $this->_url_regex_elements = $url_regex_elements;

    }

    public function indexAction() {
        echo 'Basics are functional.' . BR;
        print_r($this->_url_regex_elements);
        
    }

    public function helloAction() {

        echo 'Hello from the action method hello!<br/>';
        $services = $this->_app->_service_manager->list_services();
        print_r($services);

        $user_service = $this->_app->_service_manager->get_service('zusers', array(
            'db' => $this->_app->get_db()));
        
    }
}