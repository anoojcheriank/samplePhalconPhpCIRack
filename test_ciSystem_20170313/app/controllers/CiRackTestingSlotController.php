<?php

/*
 * Telnet library to control the box
 */
require realpath('..') ."/app/library/Telnet.php";

/*
 * Thread library to do parallel processing
 */
//require_once (realpath('..') ."/app/library/Thread.php");

/*
 *  Bash shell script with time out
 */
require_once (realpath('..') ."/app/library/BashShell.php");

/*
 *  general enums
 */
require_once (realpath('..') ."/app/library/CiRackStatus.php");

/*
 *  Logger added
 */
require_once (realpath('..') ."/app/library/Logger.php");


/*
 *This clas runs the specified test and monitoring tests in specified slot
 */
class CiRackTestingSlotController extends \Phalcon\Mvc\Controller
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

    private $testHandlerThread;

    private $isTestRunning = false;

    public function indexAction()
    {

    }

    private function setSlotIsFree($tbl_slot)
    {
        if (!is_object($tbl_slot))
        {
            echo "Slot specified nox exists \n";
            return null;
        }
        /*
         * Set slot occupied
         */
        $tbl_slot->uint_slot_availability = SlotAvailability::Available; 
        GenModelUtilityController::saveModelFn($tbl_slot);
    }

    private function setSlotOccupied ($tbl_slot)
    {
        if (!is_object($tbl_slot))
        {
            echo "Slot specified nox exists \n";
            return null;
        }
        /*
         * Set slot occupied
         */
        $tbl_slot->uint_slot_availability = SlotAvailability::NotAvailable; 
        GenModelUtilityController::saveModelFn($tbl_slot);
    }
    
    private function getBoxInSlot($tbl_slot)
    {
        if (!is_object($tbl_slot))
        {
            echo "Slot specified nox exists \n";
            return null;
        }
        /*
         * Get first box with specific platform in available slots
         */
        $tbl_box_detail = TblBoxDetails::findFirst(
            [
                'columns'    => '*',
                'conditions' => "uint_box_index = ?1",
                'bind'       => [
                    1 => $tbl_slot->uint_box_index,
                ]
            ]
        );
        if (is_object($tbl_box_detail))
        {
            echo "Free slot available with index $tbl_slot->uint_slot_index \n";
            return $tbl_box_detail;
        }
        return null;
    }

    /*
     * Returns slot details based on the availability.
     */
    private function getAvailableSlot($build_platform)
    {
        /*
         * Check available slots
         */
        $slotAvailability=SlotAvailability::Available;
        $tbl_slots = TblSlotConfig::find("uint_slot_availability = $slotAvailability");

        if (!is_object($tbl_slots))
        {
            echo "Not able to find free slots \n";
            return null;
        }

        foreach ($tbl_slots as $tbl_slot)
        {
            /*
             * Get first box with specific platform in available slots
             */
            $tbl_box_detail = TblBoxDetails::findFirst(
                [
                    'columns'    => '*',
                    'conditions' => "uint_box_index = ?1 AND uint_box_platform = ?2",
                    'bind'       => [
                        1 => $tbl_slot->uint_box_index,
                        2 => $build_platform,
                    ]
                ]
            );
            if (is_object($tbl_box_detail))
            {
                echo "Free slot available with index $tbl_slot->uint_slot_index \n";
                return $tbl_slot;
            }
        }
        return null;
    }

    public function setTestDetails (&$testHandlerList, $build_name, $build_platform)
    {
        $this->testHandlerList = &$testHandlerList;
        $this->build_name = $build_name;
        $this->build_platform = $build_platform;
    }

    /*
     * As a first level telent connections are made for each test
     * helps to reconnect if telnet connection disturbued and reestablished
     * in between individual tests. Currently doing from logs1 machine since my vm not accesssible
     * outside
     */
    public function executeBashScriptiCdiProcInBox($boxip, $testName)
    {
        $scp_yes_no="Do you want to continue connecting?";
        $scp_password='password:';
        $test_server_ip="172.16.0.78";

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
            $return = $this->telnetConnection->exec("cat /root/.ssh/known_hosts;");
            print_r($return);
            echo "\n";
            /*
             * Check if server exists in valid hosts
             */
            $returnString = (string) $return;
            $pos = strpos($returnString,$test_server_ip);
            if (false === $pos) 
            {
                $this->telnetConnection->setPrompt($scp_yes_no);
                $return = $this->telnetConnection->exec("scp racktest@172.16.0.78:~/NFSMount/anoojc/sMethod/scripts-shell/$testName/* /scripts/;");
                print_r($return);
                echo "\n";
                $this->telnetConnection->setPrompt($scp_password);
                $return = $this->telnetConnection->exec("y");
                print_r($return);       
                echo "\n";
            }
            else
            {
                $this->telnetConnection->setPrompt($scp_password);
                $return = $this->telnetConnection->exec("scp racktest@172.16.0.78:~/NFSMount/anoojc/sMethod/scripts-shell/$testName/* /scripts/;");
                print_r($return);
                echo "\n"; 
            }
            $this->telnetConnection->setPrompt("#");
            $return = $this->telnetConnection->exec("rack1234#");
            print_r($return);       
            echo "\n"; 
        }
        catch (Exception $e) {
            #echo "\n";
            #$this->telnetConnection->readToPrompt(""); // since after exception clean whatever happent
            echo "\n";
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
     * Execute cdi proc python file in box.
     */
    public function executeOsterlyCdiProcInBox($boxip, $testName)
    {

    }
 
    /*
     * Execute cdi proc python file in box.
     */
    public function executePythonCdiProcInBox($bashShell, $boxip, $testName, $uint_box_index, $char_mac)
    {

        if (!is_object($bashShell) || null==$bashShell)
        {
            echo "bashShell not exists \n";
            return -1;
        }

        /*
         * execuet python script and save the logs in server.
         */
        $pythonScriptPath = realpath('..') ."/external_scripts/scripts-python/";
        $pythonExLogPath = realpath('..') .$pythonScriptPath."/LogStrestest/".$uint_box_index."/";
        $pythonExLogFileName = "keyLog_".$char_mac."_".date('Y-m-d_h-i-s-ua').".log";
        $pythonExLogFilePath = $pythonExLogPath.$pythonExLogFileName;
        if (!file_exists($pythonExLogPath)) {
            mkdir($pythonExLogPath, 0777, true);
        }
        $output = shell_exec("touch $pythonExLogFilePath; chmod 777 $pythonExLogFilePath;");
        echo "$output \n";
        $output = shell_exec("echo \"\" > ".$pythonExLogFilePath.";");
        echo "$output \n";
        $output = shell_exec("find ".$pythonScriptPath." -iname ".$testName." | tail -1");
        $pythonFullPath = preg_replace('~[\r\n]+~', '', $output);
        echo "Python script to execute $pythonFullPath $boxip\n";
        //$output = shell_exec("python $pythonFullPath $boxip > $pythonExLogFilePath 2>$1; &");
        //$output = $bashShell->exec_1_timeout("bash -c \"python $pythonFullPath $boxip \> $pythonExLogFilePath 2\>$1;\"", null, 2);
        $output = $bashShell->execBashCmd("bash -c \"python $pythonFullPath $boxip \> $pythonExLogFilePath 2\>$1;\"", null);
        echo "$output \n";
        
    }

    /*
     * Execute bash script in the box
     */
    public function executeTestListInBox ($boxip, $uint_box_index, $char_mac)
    {
        /*
         * Based on test type execute the tests.
         */
        echo "Running Tests \n";
        echo "============= \n";
        echo "Build name: $this->build_name \n";
        echo "Build platform: $this->build_platform \n";

        /*
         * Creating a bash shell hanble by default.
         */
        $bashShell = new BashShell();
        foreach($this->testHandlerList as $testHandler)
        {
            $testList = $testHandler->getTestlist();
            $waitTime = $testHandler->getWaitTime();


            foreach($testList as $test)
            {
                /*Start test and associated monitoring tests*/
                echo "test: $test->char_test_name type: $test->uint_test_type \n";
                switch ($test->uint_test_type) {
                    //pythonCdiProc script
                    case IntTestTypes::pythonCdiProc :
                        $logger = new Logger();
                        $logger->log("This is a message");
                        $this->executePythonCdiProcInBox($bashShell, $boxip, $test->char_test_name, $uint_box_index, $char_mac); 
                        $logger->log("This is a messagei1");
                        break;
                    //shellCdiProc script
                    case IntTestTypes::shellCdiProc :
                        $this->executeBashScriptiCdiProcInBox($boxip, $test->char_test_name);
                        break;
                    //osterlyCdiProc script
                    case IntTestTypes::osterlyCdiProc :
                        $this->executeOsterlyCdiProcInBox($boxip, $test->char_test_name);
                        break;
                    //stormIR script
                    case IntTestTypes::stormIR :

                        break;
                    //timeBased script
                    case IntTestTypes::timeBased :
                        //Do nothing as it is already taken care of.
                        break;
                   default:
                       echo "Unsupported test type: $test->uint_test_type\n";
                }
     
            }

            /*
             * Stopping all bash shell threads
             */
            /*Wait for waiting time*/
            echo "Waiting $waitTime minutes ...\n";
            sleep ($waitTime * 10);
            $bashShell->disableBashCmdWait();
            /*
             * Set new time limit for execution
             */
            set_time_limit(2*($waitTime * 60));
        }
    }


    /*
     * Execute bash script in the box
     */
    public static function executeTestListInBoxStaticThread ($jobHandler, $boxip, $uint_box_index, $char_mac)
    {
        if (!is_object($jobHandler) || null==$jobHandler)
        {
            echo "jobHandler not exists \n";
            return -1;
        }
        //$boxip=$arguments[0];
        //$test=$arguments[1];
        $jobHandler->executeTestListInBox($boxip, $uint_box_index, $char_mac);

    }

    /*
     * Start the test on current slot
     */ 
    public function startTest()
    {
        if (!$this->isTestRunning)
        {
            $this->isTestRunning = true;
            /*
             * Check if slot free and execute all the tests 
             * associated in that specific slot
             */
            $tbl_slot = $this->getAvailableSlot($this->build_platform);
            if (!is_object($tbl_slot) || null==$tbl_slot)
            {
                echo "Free slots not available \n";
                return -1;
            }

            $tbl_box = $this->getBoxInSlot($tbl_slot);
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
             * Set slot occupied
             */
            //$slotController->setSlotOccupied($tbl_slot); // disabled for better use

            /*
             * Execute bash script logic. check if bash script is specified.
             */
            $this->testHandlerThread = new Thread('CiRackTestingJobHandlerController::executeTestListInBoxStaticThread');

            /*
             * start them
             */
            $this->testHandlerThread->start($this, $tbl_box->char_box_ip, $tbl_box->uint_box_index, $tbl_box->char_mac);
        }
        else
        {
            echo "Test running on this slothandler please use another slothandler\n";
        }
        //CiRackTestingJobHandlerController::executeTestListInBoxStaticThread($this, $tbl_box->char_box_ip, $tbl_box->uint_box_index, $tbl_box->char_mac);
        //$this->executeTestListInBox($tbl_box->char_box_ip, $tbl_box->uint_box_index, $tbl_box->char_mac); 

    }

    public function waitforTestToFinish()
    {
        // keep the program running until the threads finish
        while($this->testHandlerThread->isAlive()) {}
        $this->isTestRunning = false;
    }

}

