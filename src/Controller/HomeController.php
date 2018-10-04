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

        try {

            $query = $this->_app->get_db()->prepare("SELECT * FROM foo WHERE :nom");
            $args = array(':nom' => 1);
            $exec = $query->execute($args);
            $data = $query->fetchAll();

            echo $this->_app->get_render_template()->load('hello.twig.html')->render(array('data' => $data));
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

        
    }
}