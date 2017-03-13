<?php
/**
 * Logger class
 * Singleton using lazy instantiation
 */
class Logger
{
    private static $instance = NULL;

    /**
     * Gets instance of the Logger
     * @return Logger instance
     * @access public
     */
    private function getInstance() {
        if(self::$instance === NULL) {
            $logFilePath = realpath('..') ."/app/logs/test.log";
            file_put_contents($logFilePath, "");
            self::$instance = new \Phalcon\Logger\Adapter\File($logFilePath);
        }
        return self::$instance;
    }

    private function close(){
        $singleTonLogger = $this->getInstance();
        $singleTonLogger->close();
    }

    /**
     * Adds a message to the log
     * @param String $message Message to be logged
     * @access public
     */
    public function log($message) {
        $singleTonLogger = $this->getInstance();
        $singleTonLogger->log($message);
    }

    /**
     * Adds a message to the log
     * @param String $message Message to be logged
     * @access public
     */
    public function critical($message) {
        $singleTonLogger = $this->getInstance();
        $singleTonLogger->critical($message);
    }


    public function __destruct()
    {
        $this->close();
    }
};
