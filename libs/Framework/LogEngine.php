<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */
namespace Framework;

/**
 * This class allows code from within Controllers to log custom messages into the log file.
 * 
 * The path of the file to be used for logging messages can be changed in the .ini configuration file.
 */
abstract class LogEngine {

    protected $_log_file_path;
    protected $_log_file;
    protected $_config;

    /**
     * Creates a Config instance to get the needed configuration parameters. The log file is opened in append mode.
     */
    public function __construct() {

        $this->_config = new Config;
        $config_ini = $this->_config->get_config_ini();
        
        if(isset($config_ini['log_file'])) {

            $this->_log_file_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . $config_ini['log_file'];

        } else {
            $this->_log_file_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'log/applog.txt';
        }

        if (($this->_log_file = fopen($this->_log_file_path, 'a+')) === false) {
            throw new \RuntimeException('The log file could not be found. Check your configuration.');
        }

    }

    /**
     * Makes sure the log file handle is closed when the instance is destructed.
     */
    public function __destruct()
    {
        fclose($this->_log_file);
    }

    /**
     * Self-explanatory. Creates a datetime string in the format m-d-Y @ hh:mm:ss
     *
     * @return void
     */
    public function getCurrentTimeString() {
    
        $time_array = localtime(time(), True);
        
        return date('m-d-Y') . ' @ ' . 
                        $time_array['tm_hour'] . ':' .
                        $time_array['tm_min'] . ':' .
                        $time_array['tm_sec'];
    }

    /**
     * That is the method that you should call, from within the controller, to actually log a message into the defined log file.
     *
     * @param string $message
     * @return void
     */
    public function logMessage($message) {

        $lines_to_log = $this->getCurrentTimeString() . ' ==> ' . $message . PHP_EOL;

        fwrite($this->_log_file, $lines_to_log);
    }
}