<?php

class ThreadLock {

    private $lock_file;

    public function __construct() 
    {
        $lock_file_path = realpath('..') ."/app/logs/file.lock";
        $this->lock_file = fopen($lock_file_path,"w+");
    }  
    
    public function __destruct()
    {
        $this->unlock();
    }

    public function lock()
    {
        $ret = false;
        if (flock($this->lock_file,LOCK_EX))
        {
            $ret = true;
        }
        else
        {
            echo "locked\n";
        }
        return $ret;
    }
    
    public function unlock()
    {
        flock($this->lock_file, LOCK_UN);
        fclose($this->lock_file);
    }

}
