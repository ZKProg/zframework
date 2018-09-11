<?php 

namespace Controller;

use \Framework\Application;

class HomeController {

    protected $_app = null;

    public function __construct(Application &$app) {
        $this->_app = $app;
    }

    public function indexAction() {
        phpinfo();
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