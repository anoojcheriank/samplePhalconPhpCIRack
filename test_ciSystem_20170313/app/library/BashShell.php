<?php

/*
 * Thread library to do parallel processing
 */
require_once (realpath('..') ."/app/library/Thread.php");

/*
 *  Logger added
 */
require_once (realpath('..') ."/app/library/Logger.php");

class BashShell {

    private $isBashCmdWaitEnabled;
   
    private $threadHandle;
 
    private $logger;
  
    private $processList;

    public function __construct()
    {
        $this->processList = array();
        $this->logger = new Logger();
        $this->enableBashCmdWait();
        /*
         * See if threading is available
         */
        if( ! Thread::isAvailable() ) {
            die( 'Threads not supported' );
            echo "\n";
        }
        echo "Anooj----------------------\n";
        $this->threadHandle = new Thread($this, 'BashShell::ececuteBashCmdStaticThread');
    }

    public function __destruct()
    {
        /*
         * Stopping thread in case not stopped.
         */
        $this->disableBashCmdWait();
        $this->terminateProcessList();
        $this->threadHandle->stop();
        while($this->threadHandle->isAlive()) {}
    }

    public function enableBashCmdWait ()
    {
        $this->logger->log(__FUNCTION__);
        $this->isBashCmdWaitEnabled = 1;
        $this->logger->critical((string)($this->isBashCmdWaitEnabled));
    }
  
    public function disableBashCmdWait ()
    {
        $this->logger->log(__FUNCTION__);
        $this->isBashCmdWaitEnabled = 0;
        $this->logger->critical((string)($this->isBashCmdWaitEnabled));
    } 

    public function execBashCmd($cmd, $stdin = null)
    {
       $this->threadHandle->start($cmd, $stdin);
    }
 
    public static function ececuteBashCmdStaticThread (&$bashShell, $cmd, $stdin)
    {
        if (!is_object($bashShell) || null==$bashShell)
        {
            echo "Handler not exists \n";
            return -1;
        }
        $bashShell->execBashCmdAndWait($cmd, $stdin);

    }

    private function terminateProcessList ()
    {
        foreach($this->processList as $process)
        {
            proc_terminate($process);
        }
    }
  
   /**
    * @param string cmd : command to run.
    **/
    private function execBashCmdAndWait($cmd, $stdin = null)
    {
        
        $this->logger->log(__FUNCTION__);
        ob_implicit_flush(true); 
        //$this->log->debug("executing: " . $cmd . " ". $stdin);
        $cmd = str_replace("\n", "", $cmd);
        $cmd = str_replace("\r", "", $cmd);
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("pipe", "w"),  // stderr is a pipe that the child will write to
        );
        $pipes = array();
        $process = proc_open($cmd, $descriptorspec, $pipes);
        array_push($this->processList, $process);
        if (!is_resource($process)) {
            throw new Exception('Invalid resource', 1011);
        }
        $output = '';
        $error = '';
        if($stdin) {
            // 0 => writeable handle connected to child stdin
            fwrite($pipes[0], $stdin);
        }
        fclose($pipes[0]);
        ob_flush();flush();
        do {
            $write = null;
            $exceptions = null;
            if (0 == $this->isBashCmdWaitEnabled) {
                $this->logger->critical("Shell execution stopped1");
                proc_terminate($process);
                throw new Exception("Shell execution stopped", 1012);
            }
            $read = array($pipes[1],$pipes[2]);
            $timeleft=.2;//setting 2 seconds staticallly.
            stream_select($read, $write, $exceptions, $timeleft);
            if (!empty($read)) {
                $output .= fread($pipes[1], 1024);
                $error .= fread($pipes[2], 1024);
            }
            $output_exists = (!feof($pipes[1]) || !feof($pipes[2]));
            $this->logger->critical(__FUNCTION__ .(string)($this->isBashCmdWaitEnabled));
        } while ($output_exists && $this->isBashCmdWaitEnabled);
        if (0 == $this->isBashCmdWaitEnabled) {
            $this->logger->critical("Shell execution stopped2");
            proc_terminate($process);
            throw new Exception("Shell execution stopped", 1013);
        }
        $this->logger->critical("Shell execution Last");
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        if($error) {
            throw new Exception($error, 1012);
        }
        return $output;
    }


   /**
    * @param int $timeout - max process execution time in seconds until it is terminated
    **/
    public function exec_1_timeout($cmd, $stdin = null, $timeout = 600)
    {
        //$this->log->debug("executing: " . $cmd . " ". $stdin);
        $cmd = str_replace("\n", "", $cmd);
        $cmd = str_replace("\r", "", $cmd);
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("pipe", "w"),  // stderr is a pipe that the child will write to
        );
        $pipes = array();
        $timeout += time();
        $process = proc_open($cmd, $descriptorspec, $pipes);
        if (!is_resource($process)) {
            throw new Exception('Invalid resource', 1011);
        }
        $output = '';
        $error = '';
        if($stdin) {
            // 0 => writeable handle connected to child stdin
            fwrite($pipes[0], $stdin);
        }
        fclose($pipes[0]);
        do {
            $write = null;
            $exceptions = null;
            $timeleft = $timeout - time();
            if ($timeleft <= 0) {
                proc_terminate($process);
                throw new Exception("command timeout", 1012);
            }
            $read = array($pipes[1],$pipes[2]);
            stream_select($read, $write, $exceptions, $timeleft);
            if (!empty($read)) {
                $output .= fread($pipes[1], 1024);
                $error .= fread($pipes[2], 1024);
            }
            $output_exists = (!feof($pipes[1]) || !feof($pipes[2]));
        } while ($output_exists && $timeleft > 0);
        if ($timeleft <= 0) {
            proc_terminate($process);
            throw new Exception("command timeout", 1013);
        }
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        if($error) {
            throw new Exception($error, 1012);
        }
        return $output;
    }

}
