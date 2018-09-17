<?php 

namespace Framework;

abstract class LogEngine {

    protected $_log_file_path;
    protected $_log_file;
    protected $_config;

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

    public function __destruct()
    {
        fclose($this->_log_file);
    }

    public function getCurrentTimeString() {
    
        $time_array = localtime(time(), True);
        
        return date('m-d-Y') . ' @ ' . 
                        $time_array['tm_hour'] . ':' .
                        $time_array['tm_min'] . ':' .
                        $time_array['tm_sec'];
    }

    public function logMessage($message) {

        $lines_to_log = $this->getCurrentTimeString() . ' ==> ' . $message . PHP_EOL;

        fwrite($this->_log_file, $lines_to_log);
    }
}