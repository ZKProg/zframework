<?php

namespace UnitTests;

require_once("./../libs/Framework/ServiceManager.php");

use Framework;

class EncryptionEngineTest extends \PHPUnit\Framework\TestCase {

    protected $_service_manager = NULL;

    public function setUp() {
        $this->_service_manager = new \Framework\ServiceManager();
    }

    public function tearDown() {
        $this->_service_manager = NULL;
    }

    public function dataProviderAddition() {
        return array(
            array(1, 1, 2),
            array(2, 2, 4),
            array(1, 3, 4),
        );
    }

    public function testGetServices() {

       print_r($this->_service_manager->get_services());
    }
}