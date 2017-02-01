<?php

class CiRackTestingJobHandlerController extends \Phalcon\Mvc\Controller
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
     *Build name for test execution.
     */
    private $build_name;

    /*
     * Build platform. Decides to which slot 
     * test should allocated to.
     */
    private $build_platform;    


    /*
     * List all the tests based on the priority
     */   
    private function listTestList()
    {
        echo "Running Tests \n";
        echo "============= \n";
        echo "Build name: $this->build_name \n";
        echo "Build platform: $this->build_platform \n";
        foreach($this->testList as $test)
        {
            /*Start test and associated monitoring tests*/
            echo "test: $test->char_test_name type: $test->uint_test_type \n";
        }
        /*Wait for waiting time*/
        echo "Waiting $this->waitTime minutes ...\n";
    }
   
    /*
     * JobHandler constructor. 
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
   
    /*
     * Execute the test based on slot availability.
     */ 
    public function executeTest()
    {
        $this->listTestList();
        /*
         * Check if slot free and execute all the tests 
         * associated in that specific slot
         */
        $slotController = new CiRackTestingSlotController();
        $tbl_slot = $slotController->getAvailableSlot($this->build_platform);
        if (is_object($tbl_slot))
        {
            echo "Free slots not available";
            return -1;
        }
        $tbl_box = $slotController->getBoxInSlot($tbl_slot);
        if (is_object($tbl_box))
        {
            echo "Unable to get box for the slot $tbl_slot->uint_slot_index";
            return -1;
        }
    }

    /*
     * Update the build details
     */
    public function updateBuildDetails($tbl_build_details)
    {
        $this->build_name = $tbl_build_details->char_build_name;
        $this->build_platform = $tbl_build_details->uint_box_platform;
    }
}

