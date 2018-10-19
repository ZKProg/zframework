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

    public function createUser($login, $first_name, $last_name, $email, $hash, $role = 'none') {

        $created = date("Y-m-d H:i:s");

        $data = array(
            ':login' => $login,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':hash' => $hash,
            ':date' => $created, 
            ':role' => $role
        );

        // Query database to check if the user exists, or if the information provided can be accepted (no duplicate among users)
        $query_check_string = 'SELECT * FROM users';
        $query_check = $this->_db->prepare($query_check_string);
        $query_check->execute();
        $check_array = $query_check->fetchAll();
        
        foreach ($check_array as $key => $value) {

            if ($login === $value['login']) {

                echo 'A user with that login already exists.';
                return false;

            }
            
            if ($email === $value['email']) {

                echo 'A user already has an account with this email address';
                return false;

            }


        }

        $query_string = 'INSERT INTO users
                            (login, first_name, last_name, email, hash, created, role) 
                         VALUES 
                            (:login, :first_name, :last_name, :email, :hash, :date, :role)';

        $query_create_user = $this->_db->prepare($query_string);
        
        $this->_db->beginTransaction();
            $query_create_user->execute($data);
        $this->_db->commit();

    }

    public function validateAccount() {

    }

    public function deleteAccount() {

    }

    public function resetAccount() {

    }

    public function getUser($user) {

    }


}