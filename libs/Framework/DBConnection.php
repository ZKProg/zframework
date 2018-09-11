<?php 

namespace Framework;

class DBConnection {

    protected $_host, $_user, $_db, $_passwd, $_port, $_charset;
    protected $_pdo = null;

    public function __construct() {

        if ($db_config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'config/config.ini')) {

            if (isset($db_config['host']) && isset($db_config['db']) && isset($db_config['passwd'])) {

                $this->_host = $db_config['host'];
                $this->_db = $db_config['db'];
                $this->_user = $db_config['user'];
                $this->_passwd = $db_config['passwd'];
                $this->_port = isset($db_config['port']) ? $db_config['port'] : 3306;
                $this->_charset = isset($db_config['charset']) ? $db_config['charset'] : 'latin1';

            } else {
                throw new \RuntimeException('Check your DB config file. At least one parameter is missing.');
            }

        } else {
            die('The config file could not be loaded.');
        }
    }

    public function getMySQLConnection() {

        $dsn = 'mysql:host=' . $this->_host . ';dbname=' . $this->_db . ';charset=' . $this->_charset;

       
            try {
                
                $this->_pdo = new \PDO($dsn, $this->_user, $this->_passwd);
                $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->_pdo->setAttribute(\PDO::ATTR_TIMEOUT, 10);

            } catch (\PDOException $e) {
                echo $e->getMessage() . BR;
            }
        
            return $this->_pdo;
    }
        
    
}