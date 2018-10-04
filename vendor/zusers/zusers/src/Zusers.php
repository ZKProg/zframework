<?php

namespace Zusers\Zusers;

use Framework;

class Zusers {

    protected $_db;

    public function __construct(\PDO &$db) {

        $this->_db = $db;

    }
}