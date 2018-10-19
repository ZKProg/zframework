<?php
/**
 * Author: Karim Zerf
 * License: MIT.
 */
namespace Zusers;

use Framework;

/**
 * The Zusers service deals with the users registered in database.
 * It allows to check credentials, priviliges.
 * It also permits to create, activate, delete, reset user accounts.
 */
class Zusers {

    protected $_db;

    /**
     * Respects array zframework convention:
     * $in_array_db ==> means that the function expects an array to be
     * received as argument, containing the key "db"
     * 
     * @param Array $in_array_db
     * 
     */
    public function __construct($in_array_db) {

        $this->_db = $in_array_db['db'];
        

    }
}