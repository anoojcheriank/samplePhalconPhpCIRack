<?php

/**
 * This class executes the test specified in array of test handler
 * in the specific slots. It also keeps the array of slotHanders 
 * where the test is executed.
 **/
class CiRackTestingJobHandlerController extends \Phalcon\Mvc\Controller
{
    /*
     * Test list is test and its monitoring taks
     * strictly associated with a single slot
     * expects a perticular defined order of execution.
     */
    private $testHandlerList;
 
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
     * Telnet connection to box.
     */
    private $telnetConnection;

    /*
     * Job table index for the Job handler
     */
    private $tblJob;

    /*
     * Slot array to keep track of slots assigned
     */
    private $slotArray;

    /*
     * JobHandler constructor.
     * Initializes member variables
     */
    public function onConstruct()
    {
        $this->testHandlerList = array();
        $this->slotArray = array();
    }

    /*
     * Add elements to slotArray.
     */
    private function addSlot (&$slot)
    {
        array_push($this->slotArray, $slot);
    }

    /*
     * remove slot from slotArray.
     */
    private function removeSlot (&$slot)
    {
        foreach (array_keys($this->slotArray, $slot) as $key) {
            unset($this->slotArray[$key]);
        }
    }

    /*
     * List all the tests based on the priority
     */   
    private function listTestList()
    {
        echo "Running Tests \n";
        echo "============= \n";
        echo "Build name: $this->build_name \n";
        echo "Build platform: $this->build_platform \n";
        foreach($this->testHandlerList as $testHandler)
        {
            $testList = $testHandler->getTestlist();
            $waitTime = $testHandler->getWaitTime();

            foreach($testList as $test)
            {
                /*Start test and associated monitoring tests*/
                echo "test: $test->char_test_name type: $test->uint_test_type \n";
            }
            /*Wait for waiting time*/
            echo "Waiting $waitTime minutes ...\n";
        }
    }


    public function indexAction()
    {

    }

    /*
     * Append new test to the end of test list
     */
    public function appendToTestHandlerlist($testHandler)
    {
        array_push($this->testHandlerList, $testHandler);
    }
   
    /*
     *
     */
    public function UpdateTblJobDetails($tblJob)
    {
        $this->tblJob = $tblJob;
    }

    /*
     * Execute the test based on slot availability.
     */ 
    public function executeTest()
    {
        /*
         * Check if slot free and execute all the tests 
         * associated in that specific slot
         */
        $slotController = new CiRackTestingSlotController();

        $slotController->setTestDetails ($this->testHandlerList, $this->build_name, $this->build_platform);
        $this->addSlot($slotController);

        $slotController->startTest();

        /*
         * Set Job status in progress
         */
        $this->tblJob->uint_job_status = JobState::InProgress;
        GenModelUtilityController::saveModelFn($this->tblJob);

        //Need to decide when Job status completed and slot will be available again

       /*
         * Set Job status completed 
         */
        //$this->tblJob->uint_job_status = JobState::Completed;
        //GenModelUtilityController::saveModelFn($this->tblJob);

        /*
         * Set slot if free
         */
        //$slotController->setSlotIsFree($tbl_slot);

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

