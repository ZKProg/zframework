<?php

namespace UnitTests;
require_once("../Framework/EncryptionEngine.php");
require_once("../autoload.php");

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
        return array(
            array(1, 1, 2),
            array(2, 2, 4),
            array(1, 3, 4),
        );
    }

    /**
     * @dataProvider dataProviderAddition
     *
     * @return void
     */
    public function testHello($a, $b, $expected) {

        $result = $this->_encryptionEngine->add($a, $b);
        $this->assertEquals($expected, $result);

    }
}