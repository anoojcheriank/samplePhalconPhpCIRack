<?php

class CiRackTestingReqHandlerController extends \Phalcon\Mvc\Controller
{
    /*
     *  Job hander executes the Job specified in the internal database Queue
     */
    //private $jobHandler; // = new TblJobQueue(); //new CiRackTestingJobHandlerController();

    public function onConstruct()
    {
        //$this->jobHandler = new CiRackTestingJobHandlerController();
    }

    public function indexAction()
    {
    }
    
    /*
     * Save model specified in parameter to configured database;
     */
    private function saveModelFn($modelObject)
    {
        if (!$modelObject->save()) {
            foreach ($modelObject->getMessages() as $message) {
                print_r($message);
            }
        }
    }

    /*
     * Delete model specified in parameter to configured database;
     */
    private function deleteModelFn($modelObject)
    {
        if (!$modelObject->delete()) {
            foreach ($modelObject->getMessages() as $message) {
                print_r($message);
            }
        }
    }



    /*
     * Checks if shared json Job is valid
     */
    private function checkJobDataValidity($jsonJob)
    {
        if (!isset($jsonJob->job_id))
        {
            echo "jsonJob->job_id not set";
            return -1;
        }
        if (!isset($jsonJob->priority))
        {
            echo "jsonJob->priority not set";
            return -1;
        }
        if (!isset($jsonJob->number_of_boxes))
        {
            echo "jsonJob->number_of_boxes not set";
            return -1;
        }
        if(0 == $jsonJob->number_of_boxes)
        {
            echo "jsonJob->number_of_boxes zero is not a vaild test";
            return -1;
        }

        $build_details=$jsonJob->build_details;
        if (!isset($build_details->build_name))
        {
            echo "build_details->build_name not set";
            return -1;
        }
        if (!isset($build_details->build_platform))
        {
            echo "build_details->build_platform not set";
            return -1;
        }
        if (!isset($build_details->build_type))
        {
            echo "build_details->build_type not set";
            return -1;
        }
        if (!isset($build_details->Middleware_version))
        {
            echo "build_details->Middleware_version not set";
            return -1;
        }

        $tests_details=$jsonJob->tests_details;
        foreach ($tests_details as $test) 
        {
           if (!isset($test->name))
           {
                echo "test->name not set";
                return -1;
           }
           if (!isset($test->type))
           {
                echo "test->type not set";
                return -1;
           }

           $tbl_test = TblTest::findFirst(
                [
                    'columns'    => '*',
                    'conditions' => "char_test_name = ?1 AND uint_test_type = ?2",
                    'bind'       => [
                        1 => $test->name,
                        2 => $test->type,
                    ]
                ]
            );

            if (!is_object($tbl_test))
            {
                echo "Test not found with name: $test->name and type: $test->type \n";
                return -1;
            }

            if (isset($test->monitoring_tasks))
            {
                $monitorTestCount = 1;
                $monitoring_tasks=$test->monitoring_tasks;
                foreach ($monitoring_tasks as $monitoring_task) 
                {
                    if (!isset($monitoring_task->name))
                    {
                        echo "monitoring_task->name not set";
                        return -1;
                    }
                    if (!isset($monitoring_task->type))
                    {
                        echo "monitoring_task->type not set";
                        return -1;
                    }
                    $tbl_monitor_test = TblTest::findFirst(
                        [
                            'columns'    => '*',
                            'conditions' => "char_test_name = ?1 AND uint_test_type = ?2",
                            'bind'       => [
                                1 => $monitoring_task->name,
                                2 => $monitoring_task->type,
                            ]
                        ]
                    );

                    if (!is_object($tbl_monitor_test))
                    {
                        echo "Test not found with name: $monitoring_task->name and type: $monitoring_task->type \n";
                        return -1;
                    }

                    if (isset($monitoring_task->timeout_in_minutes)) 
                    {
                        if (0 > $monitoring_task->timeout_in_minutes)
                        {
                            echo "Test timeout should be greater than zero";
                            return -1;
                        }
                    }


                }
            }
         }
         return 0;
    }

    /*
     * Schedule the job specified in json to 
     * internal database job queue
     */
    public function scheduleJob($jsonArg)
    {
        $jsonJob=$jsonArg->__job;
 
        /*
         * Check if passed json data is valid
         */
        if (0 != $this->checkJobDataValidity($jsonJob))
        {
            return -1;
        }

        echo "job_id: $jsonJob->job_id \n";
        echo "priority: $jsonJob->priority \n";
        echo "number_of_boxes: $jsonJob->number_of_boxes \n";

        /*
         * Check if job already exists in the queue. If yes exit
         */
        $tbl_job_queue_check = TblJobQueue::findFirst(
            [
                'columns'    => '*',
                'conditions' => "uint_job_id = ?1",
                'bind'       => [
                    1 => $jsonJob->job_id,
                ]
            ]
        );
        if (is_object($tbl_job_queue_check))
        {
            echo "Job id already exists in the queue with ID: $tbl_job_queue_check->uint_job_id \n";
            return -1;
        }

        /*
         * Enter Job queue details
         */      
        $tbl_job_queue = new TblJobQueue();
        $tbl_job_queue->uint_job_id = $jsonJob->job_id;
        $tbl_job_queue->uint_priority = $jsonJob->priority;
        $tbl_job_queue->uint_number_of_boxes = $jsonJob->number_of_boxes;
        $tbl_job_queue->uint_job_status = "SCHEDULED"; /*Need to add with enum*/

        $build_details=$jsonJob->build_details;
        echo "build_details[build_name]: $build_details->build_name \n";
        echo "build_details[build_platform]: $build_details->build_platform \n";
        echo "build_details[build_type]: $build_details->build_type \n";
        echo "build_details[Middleware_version]: $build_details->Middleware_version \n";

        //$build_md5sum = md5_file($build_details->build_name);    /*Calculate md5 sum of real binay here*/
        $build_md5sum = md5($build_details->build_name);
        /*
         * Check if build already exists in the queue. If yes link the existing build
         */
        $tbl_build_details_check = TblBuildDetails::findFirst(
            [
                'columns'    => '*',
                'conditions' => "char_build_md5sum = ?1",
                'bind'       => [
                    1 => $build_md5sum,
                ]
            ]
        );
        if (is_object($tbl_build_details_check))
        {
            echo "Binary already exists in queue name:: $tbl_build_details_check->char_build_name \n";
            $tbl_job_queue->uint_build_index = $tbl_build_details_check->uint_build_index;
            $this->saveModelFn($tbl_job_queue);
        }
        else
        {
            /*
             * Save build details
             */
            $tbl_build_details = new TblBuildDetails();
            $tbl_build_details->char_build_name = $build_details->build_name;
            $tbl_build_details->uint_box_platform = $build_details->build_platform;
            $tbl_build_details->char_build_md5sum = $build_md5sum;    
            $tbl_build_details->uint_build_type = 1; //$build_details->build_type;
            $tbl_build_details->char_middleware_version = $build_details->Middleware_version;
            $this->saveModelFn($tbl_build_details);

            $tbl_job_queue->uint_build_index = $tbl_build_details->getWriteConnection()->lastInsertId();
            $this->saveModelFn($tbl_job_queue);
        }
        
        $testCount = 1;
        $tests_details=$jsonJob->tests_details;
        foreach ($tests_details as $test) 
        {
            echo "test[name]: $test->name \n";
            echo "test[type]: $test->type \n";
            /*
             * No need to add test details details are already aaded and only need to link to 
             */
            $tbl_internal_queue = new TblInternalQueue();
            $tbl_internal_queue->uint_job_id = $tbl_job_queue->uint_job_id;
            $tbl_internal_queue->uint_seq_order = $testCount;
            
            $tbl_test = TblTest::findFirst(
                [
                    'columns'    => '*',
                    'conditions' => "char_test_name = ?1 AND uint_test_type = ?2",
                    'bind'       => [
                        1 => $test->name,
                        2 => $test->type,
                    ]
                ]
            );

            if (is_object($tbl_test))
            {
                echo "uint_test_index  $tbl_test->uint_test_index\n";
                $tbl_internal_queue->uint_test_index = $tbl_test->uint_test_index;
            }

            $this->saveModelFn($tbl_internal_queue);

            if (isset($test->monitoring_tasks))
            {
                $monitorTestCount = 1;
                $monitoring_tasks=$test->monitoring_tasks;
                foreach ($monitoring_tasks as $monitoring_task) 
                {
                    echo "monitoring_task[name]: $monitoring_task->name \n";
                    echo "monitoring_task[type]: $monitoring_task->type \n";
                    $tbl_monitoring_task_seq_of_test = new TblMonitoringTaskSeqOfTest();
                    $tbl_monitoring_task_seq_of_test->uint_internalQ_mapping_index = $tbl_internal_queue->uint_internalQ_mapping_index;
                    $tbl_monitoring_task_seq_of_test->uint_monitor_task_seq_order = $monitorTestCount;
                    $tbl_monitoring_task_seq_of_test->uint_monitor_test_status = 1; /*Need to add with enum*/
                    if (isset($monitoring_task->timeout_in_minutes)) 
                    {
                        echo "monitoring_task[timeout_in_minutes]: $monitoring_task->timeout_in_minutes \n";
                        $tbl_monitoring_task_seq_of_test->uint_monitor_test_wait = $monitoring_task->timeout_in_minutes; /*Change this time to uint*/
                    }

                    $tbl_monitor_test = TblTest::findFirst(
                        [
                            'columns'    => '*',
                            'conditions' => "char_test_name = ?1 AND uint_test_type = ?2",
                            'bind'       => [
                                1 => $monitoring_task->name,
                                2 => $monitoring_task->type,
                            ]
                        ]
                    );

                    if (is_object($tbl_monitor_test))
                    {                  
                        echo "tbl_monitor_test->uint_test_index  $tbl_monitor_test->uint_test_index\n";
                        $tbl_monitoring_task_seq_of_test->uint_monitor_test_index = $tbl_monitor_test->uint_test_index; 
                    }


                    $this->saveModelFn($tbl_monitoring_task_seq_of_test);

                    $monitorTestCount++;
                }
            }

            $testCount++;
        }

    }

    /*
     * List all job ids
     */
    public function listAllJobIds()
    {
        /*
         * Check if job already exists in the queue. If yes exit
         */
        $tbl_job_queue = TblJobQueue::find();
        if (!is_object($tbl_job_queue))
        {
            echo "Job queue is empty\n";
            return -1;
        }
        echo "Jobs \n";
        echo "---- \n";
        foreach ($tbl_job_queue as $tbl_job) 
        {
            echo "ID: $tbl_job->uint_job_id  Priority: $tbl_job->uint_priority Status: $tbl_job->uint_job_status\n";
        }

    }

    /*
     * cancel specified Job
     */
    public function cancelJob($jobid)
    {
        /*
         * Get Job based on Job id.
         */
        $tbl_job = TblJobQueue::findFirst(
            [
                'columns'    => '*',
                'conditions' => "uint_job_id = ?1",
                'bind'       => [
                    1 => $jobid,
                ]
            ]
        );
        if (!is_object($tbl_job))
        {
            echo "Specified jobid not exists in database ID: $jobid \n";
            return 0;
        }

        /*
         * Get Job based on Job id.
         */
        $tbl_internal_queue = TblInternalQueue::find(
            [
                'columns'    => '*',
                'conditions' => "uint_job_id = ?1",
                'bind'       => [
                    1 => $jobid,
                ]
            ]
        );
        if (!is_object($tbl_internal_queue))
        {
            echo "No test specified in the Job: $jobid \n";
            return 0;
        }
      
        foreach ($tbl_internal_queue as $tbl_internal_job) 
        {

            /*
             * Get Job based on Job id.
             */
            $monitoring_tasks = TblMonitoringTaskSeqOfTest::find(
                [
                    'columns'    => '*',
                    'conditions' => "uint_internalQ_mapping_index = ?1",
                    'bind'       => [
                        1 => $tbl_internal_job->uint_internalQ_mapping_index,
                    ]
                ]
            );
            if (!is_object($monitoring_tasks))
            {
                echo "No monitoring tasks for testid: $tbl_internal_job->uint_internalQ_mapping_index \n";
                return 0;
            }
          
            foreach ($monitoring_tasks as $monitoring_task) 
            {
                /*
                 * Delete associated monitoring tasks
                 */
                $this->deleteModelFn($monitoring_task);
                echo "Deleted associated monitoring job with id: $monitoring_task->uint_monitror_test_mapping_index \n";
            }
            /*
             * Delete associated monitoring tasks
             */
            $this->deleteModelFn($tbl_internal_job);
            echo "Deleted internal job with id: $tbl_internal_job->uint_internalQ_mapping_index \n";
         
        }

        /*
         * Delete job
         */
        $this->deleteModelFn($tbl_job);//Need to do at last
        echo "Deleted job with id: $tbl_job->uint_job_id \n";

    }

    /*
     * Process individal jobs in job queue
     */
    private function processMonTasks($tbl_internal_test_details, $jobHandler)
    {

        $time_out_in_mins = 3* 24 * 60; /*Two days run by default if not specified else*/        
        
        $tbl_monitoring_task_queue = TblMonitoringTaskSeqOfTest::find(
            [
                'columns'    => '*',
                "order" => "uint_monitor_task_seq_order",
                'conditions' => "uint_internalQ_mapping_index = ?1",
                'bind'       => [
                        1 => $tbl_internal_test_details->uint_internalQ_mapping_index,
                    ]
            ]
        );

        if (!is_object($tbl_monitoring_task_queue))
        {
            echo "No monitoring tasks for mapping index $tbl_internal_test_details->uint_internalQ_mapping_index";
            return -1;
        }

        
        foreach ($tbl_monitoring_task_queue as $tbl_monitoring_task_details) 
        {
            /*
             * Find test link to the Queue and fire it
             */
            $tbl_test = TblTest::findFirst(
                [
                    'columns'    => '*',
                    'conditions' => "uint_test_index = ?1",
                    'bind'       => [
                        1 => $tbl_monitoring_task_details->uint_monitor_test_index
                    ]
                ]
            );

            if (is_object($tbl_test))
            {
                echo "test->name: $tbl_test->char_test_name \n";
                echo "test->type: $tbl_test->uint_test_type \n";
            }
            if (isset($tbl_monitoring_task_details->uint_monitor_test_wait))
            {
                echo "tbl_monitoring_task_details->uint_monitor_test_wait: $tbl_monitoring_task_details->uint_monitor_test_wait \n";
                /*Update job wait itme in job handler*/
                $jobHandler->updateWaitTime($tbl_monitoring_task_details->uint_monitor_test_wait);
            }
            /*
             * Add test cases to Job handler
             */
            $jobHandler->appendToTestlist($tbl_test);
        }
    }
 
    /*
     * Process individal jobs in job queue
     */
    private function processJob($tbl_job)
    {
        /*Create a job handler to execute the task*/
        $jobHandler = new CiRackTestingJobHandlerController();

        /*
         * Add the build name and build type to Job Handler
         */
        $tbl_build_details = TblBuildDetails::findFirst(
            [
                'columns'    => '*',
                'conditions' => "uint_build_index = ?1",
                'bind'       => [
                        1 => $tbl_job->uint_build_index,
                    ]
            ]
        );

        if (!is_object($tbl_build_details))
        {
            echo "Not able to find build details of Job id: $tbl_job->uint_job_id \n";
            return -1;
        }

        $jobHandler->updateBuildDetails($tbl_build_details); 

        $tbl_internal_test_queue = TblInternalQueue::find(
            [
                'columns'    => '*',
                "order" => "uint_seq_order",
                'conditions' => "uint_job_id = ?1",
                'bind'       => [
                        1 => $tbl_job->uint_job_id,
                    ]
            ]
        );

        if (!is_object($tbl_internal_test_queue))
        {
            echo "Not able to find tests for the Job with Job id: $tbl_job->uint_job_id \n";
            return -1;
        }


        foreach ($tbl_internal_test_queue as $tbl_internal_test_details) 
        {
            /*
             * Find test link to the Queue and fire it
             */
            $tbl_test = TblTest::findFirst(
                [
                    'columns'    => '*',
                    'conditions' => "uint_test_index = ?1",
                    'bind'       => [
                        1 => $tbl_internal_test_details->uint_test_index
                    ]
                ]
            );

            if (is_object($tbl_test))
            {
                echo "test->name: $tbl_test->char_test_name \n";
                echo "test->type: $tbl_test->uint_test_type \n";
                /*
                 * Fire actual tests here
                 */
            }
            /*
             * Add test cases to Job handler
             */
            $jobHandler->appendToTestlist($tbl_test);

            /*
             * find monitoring tests link to the Queue and fire it.
             */
            $this->processMonTasks($tbl_internal_test_details, $jobHandler);

        }
        /**
         * Start the test execution
         **/
        $jobHandler->executeTest();

    }
  

    /*
     * Process Job queue based on priority
     */
    public function processJobQueue()
    {
        /*
         * Find Job by priority
         */
        $tbl_job_queue = TblJobQueue::find(
            [
                'columns'    => '*',
                "order" => "uint_priority ASC"
            ]
        );

        if (!is_object($tbl_job_queue))
        {
            echo "Job queue is empty \n";
            return -1;
        }
 
        foreach ($tbl_job_queue as $tbl_job) 
        {
            echo "job_id: $tbl_job->uint_job_id \n";
            echo "priority: $tbl_job->uint_priority \n";
            echo "number_of_boxes: $tbl_job->uint_number_of_boxes \n";
            $this->processJob($tbl_job);
            //$tbl_job_queue->uint_job_status = "SCHEDULED"; /*Need to add with enum*/
        }

    }

}

