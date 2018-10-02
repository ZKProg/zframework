<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */
namespace Framework;

/**
 * The DBConnection represention the relationship that the frameworks has with a database server.
 * It holds the the settings from the config file (and checks if the congiguration file is correct). The Application PDO is gotten thanks to this class.
 */
class DBConnection {

    protected $_host, $_user, $_db, $_passwd, $_port, $_charset;
    protected $_pdo = null;

    /**
     * The constructor takes the Application Config instance, from where it gets the parameters and credentials.
     * 
     * Throws a RuntimeException in case a parameter is missing of if the file keys are not correct.
     *
     * @param Config $db_config
     */
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

    /**
     * Returns the PDo, give the configuration initiated in the constructor.
     *
     * @return PDO $_pdo
     */
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