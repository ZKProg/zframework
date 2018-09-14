<?php

namespace UnitTests;
require_once(__DIR__. "/../Framework/EncryptionEngine.php");
require_once(__DIR__. "/../autoload.php");

use PHPUnit\Framework\TestCase;
use Framework;

class EncryptionEngineTest extends TestCase {

    protected $_encryptionEngine = NULL;

    public function setUp() {
        $this->_encryptionEngine = new Framework\EncryptionEngine;
    }

    public function tearDown() {
        $this->_encryptionEngine = NULL;
    }

    public function dataProviderAddition() {
        
    }

    // TODO Implement tests
}