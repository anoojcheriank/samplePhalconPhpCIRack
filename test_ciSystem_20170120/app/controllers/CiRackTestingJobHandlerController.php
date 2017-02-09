<?php

/*
 * Telnet library to control the box
 */
require realpath('..') ."/app/library/Telnet.php";

/*
 * Thread library to do parallel processing
 */
require_once (realpath('..') ."/app/library/Thread.php");

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
     *
     */
    private $telnetConnection;

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
     * As a first level telent connections are made for each test
     * helps to reconnect if telnet connection disturbued and reestablished
     * in between individual tests.
     */
    public function executeBashScriptInBox($boxip, $testName)
    {
        $scp_yes_no="Do you want to continue connecting";
        $scp_password='password:';

        $this->telnetConnection = new Telnet($boxip, '23', 10, "login:", 1);
        $this->telnetConnection->login("root", "");
        $this->telnetConnection->setPrompt("#");
        $return = $this->telnetConnection->exec("mkdir /scripts;");
        print_r($return);       
        echo "\n"; 
        $return = $this->telnetConnection->exec("rm -rf  /scripts/*;");
        print_r($return);       
        echo "\n";
        try { 
            $this->telnetConnection->setPrompt($scp_yes_no);
            $return = $this->telnetConnection->exec("scp racktest@172.16.0.78:~/NFSMount/anoojc/sMethod/scripts-shell/$testName/* /scripts/;");
            print_r($return);       
            echo "\n"; 
            $this->telnetConnection->setPrompt($scp_password);
            $return = $this->telnetConnection->exec("y");
            print_r($return);       
            echo "\n"; 
            $this->telnetConnection->setPrompt("#");
            $return = $this->telnetConnection->exec("rack1234#");
            print_r($return);       
            echo "\n"; 
        }
        catch (Exception $e) {
            sleep (1); /*Just to by passs password prompt*/
            $this->telnetConnection->setPrompt("#");
            $return = $this->telnetConnection->exec("rack1234#");
            print_r($return);       
            echo "\n"; 
        }
        $return = $this->telnetConnection->exec("cd /scripts;");
        print_r($return);       
        echo "\n"; 
        $return = $this->telnetConnection->exec("chmod 777 *");
        print_r($return);       
        echo "\n"; 
        $return = $this->telnetConnection->exec("./sh*;");
        print_r($return);       
        echo "\n";

    }

    /*
     * Execute bash script in the box
     */
    public function executeTestListInBox ($boxip)
    {
        /*
         * Based on test type execute the tests.
         */
        echo "Running Tests \n";
        echo "============= \n";
        echo "Build name: $this->build_name \n";
        echo "Build platform: $this->build_platform \n";
        foreach($this->testList as $test)
        {
            /*Start test and associated monitoring tests*/
            echo "test: $test->char_test_name type: $test->uint_test_type \n";
            switch ($test->uint_test_type) {
                //pythonCdiProc script
                case 0:
                    
                    break;
                //shellCdiProc script
                case 1:
                    $this->executeBashScriptInBox($boxip, $test->char_test_name);
                    break;
                //osterlyCdiProc script
                case 2:

                    break;
                //stormIR script
                case 3:

                    break;
                //timeBased script
                case 4:

                    break;
               default:
                   echo "Unsupported test type: $test->uint_test_type\n";
            }
 
        }
        /*Wait for waiting time*/
        echo "Waiting $this->waitTime minutes ...\n";
        /*
         * Set new time limit for execution
         */
        set_time_limit(2*($this->waitTime * 60));
        sleep ($this->waitTime * 60);

    }


    /*
     * Execute bash script in the box
     */
    public static function executeTestListInBoxStaticThread ($jobHandler, $boxip)
    {
        if (!is_object($jobHandler) || null==$jobHandler)
        {
            echo "jobHandler not exists \n";
            return -1;
        }
        //$boxip=$arguments[0];
        //$test=$arguments[1];
        $jobHandler->executeTestListInBox($boxip);

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
        $tbl_slot = $slotController->getAvailableSlot($this->build_platform);
        if (!is_object($tbl_slot) || null==$tbl_slot)
        {
            echo "Free slots not available \n";
            return -1;
        }

        $tbl_box = $slotController->getBoxInSlot($tbl_slot);
        if (!is_object($tbl_box) || null==$tbl_box)
        {
            echo "Unable to get box for the slot $tbl_slot->uint_slot_index\n";
            return -1;
        }
        
        /*
         * See if threading is available
         */
        if( ! Thread::isAvailable() ) {
            die( 'Threads not supported' );
            echo "\n";
        }

        /*
         * Execute bash script logic. check if bash script is specified.
         */
        $t1 = new Thread('CiRackTestingJobHandlerController::executeTestListInBoxStaticThread');

        /*
         * start them
         */
        $t1->start($this, $tbl_box->char_box_ip);

        // keep the program running until the threads finish
        while($t1->isAlive()) {}
       
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

