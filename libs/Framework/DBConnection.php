<?php 

namespace Framework;

class DBConnection {

    protected $_host, $_user, $_db, $_passwd, $_port, $_charset;
    protected $_pdo = null;

    public function __construct($db_config) {

        if (isset($db_config['database']['host']) && isset($db_config['database']['db']) && isset($db_config['database']['passwd'])) {

            $this->_host = $db_config['database']['host'];
            $this->_db = $db_config['database']['db'];
            $this->_user = $db_config['database']['user'];
            $this->_passwd = $db_config['database']['passwd'];
            $this->_port = isset($db_config['database']['port']) ? $db_config['database']['port'] : 3306;
            $this->_charset = isset($db_config['database']['charset']) ? $db_config['database']['charset'] : 'latin1';

        } else {
            throw new \RuntimeException('Check your DB config file. At least one parameter is missing.');
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