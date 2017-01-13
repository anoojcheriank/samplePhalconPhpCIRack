<?php

class CiRackTestingReqHandlerController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }
    
    public function someFn()
    {
        echo "\n inside someFn";
    }
   
    public function scheduleJob($jsonJob)
    {
        print_r($jsonJob);
    }
}

