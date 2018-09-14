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
        
    }

    // TODO Implement tests

  
}