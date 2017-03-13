<?php

/*
 * This class store the test and its associated monitoring tests and wait time.
 */
class CiRackTestingTestHandlerController extends \Phalcon\Mvc\Controller
{

    /*
     * Test list is test and its monitoring taks
     * strictly associated with a single slot
     * expects a perticular defined order of execution.
     */
    private $testList;

    /*
     * It is the maximum wait time need to wait for
     * the job.
     */
    private $waitTime; /*Two days in minutes*/

    /*
     * Status to show weather wait tme is user defined
     */
    private $isDefaultWaitTime;

    /*
     * testHandler constructor.
     * Initializes member variables
     */
    public function onConstruct()
    {
        $this->testList = array();
        $this->waitTime = 2 * 24 * 60;
        $this->isDefaultWaitTime = true;
    }

    public function indexAction()
    {

    }

    /*
     * Append new test to the end of test list
     */
    public function appendToTestlist($test)
    {
        array_push($this->testList, $test);
    }

    /*
     * Highest waittime specified in monitoring taks will be taken.
     */
    public function updateWaitTime($newWaitTime)
    {
        if (true == $this->isDefaultWaitTime && 0 != $newWaitTime)
        {
            $this->waitTime = $newWaitTime;
            $this->isDefaultWaitTime = false;
            return 0;
        }
        if($this->waitTime < $newWaitTime)
        {
            $this->waitTime = $newWaitTime;
        }
    }

    public function getTestlist()
    {
        return $this->testList;
    }

    public function getWaitTime()
    {
        return $this->waitTime;
    }
}

