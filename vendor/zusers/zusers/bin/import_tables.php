<?php
/**
 * Author: Karim Zerf
 * License: MIT.
 */

// Semi-Procedural script to create the necessary tables

/**
 * This class permits to create all the necessary tables. This file needs to be run in CLI.
 * 
 * *Note* that the default configuration file is the one located at the root of the folder bin. If removed, the config file used 
 * will be the one from the ZFramework itself.
 */
class CreateTables {

    protected $_pdo = null;
    protected $_host, $_db, $_user, $_passwd, $_port, $_charset;

    public function __construct() {

        // We use in priority the config.ini located at the root of zusers/zusers/bin
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini')) {

            if (($db_config = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini')) === FALSE) {

                die('The ini config file could not be loaded.');

            } 

        // If no config.ini is located in the bin folder, parse the Zframework global config.ini
        } else {

            
            if (($db_config = parse_ini_file(__DIR__ . '/../../../../config/config.ini')) === FALSE) {

                die('The ini config file could not be loaded.');

            } 

        }

        
        if (isset($db_config['database_users']['host']) && isset($db_config['database_users']['db']) && isset($db_config['database_users']['passwd'])) {

            $this->_host = $db_config['database_users']['host'];
            $this->_db = $db_config['database_users']['db'];
            $this->_user = $db_config['database_users']['user'];
            $this->_passwd = $db_config['database_users']['passwd'];
            $this->_port = isset($db_config['database_users']['port']) ? $db_config['database_users']['port'] : 3306;
            $this->_charset = isset($db_config['database_users']['charset']) ? $db_config['database_users']['charset'] : 'latin1';

        } else {
            throw new \RuntimeException('Check your database config file. At least one parameter is missing.');
        }

        $dsn = 'mysql:host=' . $this->_host . ';dbname=' . $this->_db . ';charset=' . $this->_charset;
       
            try {
                
                $this->_pdo = new \PDO($dsn, $this->_user, $this->_passwd);
                $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->_pdo->setAttribute(\PDO::ATTR_TIMEOUT, 10);

            } catch (\PDOException $e) {
                echo $e->getMessage() . BR;
            }
        
    }


    public function createTables() {
        
        $users_table_string = "CREATE TABLE IF NOT EXISTS `". $this->_db . "`.`users` (
            `idusers` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `login` VARCHAR(256) NOT NULL,
            `first_name` VARCHAR(256) NOT NULL,
            `last_name` VARCHAR(256) NOT NULL,
            `email` VARCHAR(256) NOT NULL,
            `hash` TEXT NOT NULL,
            `last_connection` DATETIME NULL,
            `created` DATETIME(0) NOT NULL,
            `role` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`idusers`))";

        $roles_table_string = "CREATE TABLE IF NOT EXISTS `" . $this->_db . "`.`roles` (
            `idroles` INT NOT NULL AUTO_INCREMENT,
            `role` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`idroles`),
            UNIQUE INDEX `role_UNIQUE` (`role` ASC))";

        try {

            $this->_pdo->exec($users_table_string);
            $this->_pdo->exec($roles_table_string);
   
            printf("Tables successfully created (or already existing)." . PHP_EOL);

        } catch (PDOException $e) {

            printf($e->getMessage());

        }

        $test_query = $this->_pdo->prepare("SELECT role FROM roles WHERE 1");
        $test_query->execute();

        $test = $test_query->fetchAll();

        if (count($test) === 0) {
            try {

                $this->_pdo->exec("INSERT INTO roles (role) VALUES ('admin')");
                $this->_pdo->exec("INSERT INTO roles (role) VALUES ('contributor')");
                $this->_pdo->exec("INSERT INTO roles (role) VALUES ('visitor')");
                $this->_pdo->exec("INSERT INTO roles (role) VALUES ('none')");

                printf("Table 'roles' should now be populated." . PHP_EOL);

            } catch (PDOException $e) {

                printf($e->getMessage());

            }
        }

    }

}

$create_tables = new CreateTables;
$create_tables->createTables();
