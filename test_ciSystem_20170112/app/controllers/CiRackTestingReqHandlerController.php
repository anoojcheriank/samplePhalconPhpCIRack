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
   
    public function scheduleJob($jsonArg)
    {
        #print_r($jsonJob);
        $jsonJob=$jsonArg->__job;
        echo "job_id: $jsonJob->job_id \n";
        echo "priority: $jsonJob->priority \n";
        echo "number_of_boxes: $jsonJob->number_of_boxes \n";
        /*
         * Enter Job queue details
         */
        $tbl_job_queue = new TblJobQueue();
        //$tbl_job_queue->uint_job_id = $jsonJob->job_id;
        $tbl_job_queue->uint_priority = $jsonJob->priority;
        $tbl_job_queue->uint_number_of_boxes = $jsonJob->priority;
        $tbl_job_queue->uint_job_status = "SCHEDULED";


        $build_details=$jsonJob->build_details;
        echo "build_details[build_name]: $build_details->build_name \n";
        echo "build_details[build_platform]: $build_details->build_platform \n";
        echo "build_details[build_type]: $build_details->build_type \n";
        echo "build_details[Middleware_version]: $build_details->Middleware_version \n";
        /*
         * Save build details
         */
        $tbl_build_detail = new TblBuildDetails();
        $tbl_build_detail->char_build_name = $build_details->build_name;
        $tbl_build_detail->uint_box_platform = $build_details->build_platform;
        $tbl_build_detail->char_build_md5sum = "";
        $tbl_build_detail->uint_build_type = $build_details->build_type;
        $tbl_build_detail->char_middleware_version = $build_details->Middleware_version;
        /*if (!$tbl_build_detail->save()) {
            foreach ($tbl_build_detail->getMessages() as $message) {
                print_r($message);
            }
        }*/

        $tbl_job_queue->uint_build_index = $tbl_build_detail->getWriteConnection()->lastInsertId();
        /*if (!$tbl_job_queue-->save()) {
            foreach ($tbl_job_queue-->getMessages() as $message) {
                print_r($message);
            }
        }*/
        
        $testCount = 1;
        $tests_details=$jsonJob->tests_details;
        foreach ($tests_details as $test) 
        {
            echo "test[name]: $test->name \n";
            echo "test[type]: $test->type \n";
            /*
             * No need to add test details details are already aaded and only need to link to 
             * 
             */
            $tbl_internal_queue = new TblInternalQueue();
            $tbl_internal_queue->uint_job_id = $tbl_job_queue->getWriteConnection()->lastInsertId();
            $tbl_internal_queue->uint_seq_order = $testCount;
            
            $tbl_test = TblTest::findFirst(
                [
                    'columns'    => '*',
                    'conditions' => 'char_test_name = ?1 AND uint_test_type = ?2',
                    'bind'       => [
                        1 => $test->name,
                        2 => $test->type,
                    ]
                ]
            );
            $tbl_internal_queue->uint_test_index = $tbl_test->uint_test_index;

            //Following details need to be processed during test processing
            /*  $tbl_internal_queue->uint_slot_index = $this->request->getPost("uint_slot_index");
            $tbl_internal_queue->datetime_test_start = $this->request->getPost("datetime_test_start");
            $tbl_internal_queue->datetime_test_finish = $this->request->getPost("datetime_test_finish");
            $tbl_internal_queue->uint_test_status = $this->request->getPost("uint_test_status");
            $tbl_internal_queue->uint_test_check_job_type = $this->request->getPost("uint_test_check_job_type");
            $tbl_internal_queue->time_test_wait = $this->request->getPost("time_test_wait"); */
            /*if (!$tbl_internal_queue->save()) {
            }*/

            if (isset($test->monitoring_tasks))
            {
                $monitorTestCount = 1;
                $monitoring_tasks=$test->monitoring_tasks;
                foreach ($monitoring_tasks as $monitoring_task) 
                {
                    echo "monitoring_task[name]: $monitoring_task->name \n";
                    echo "monitoring_task[type]: $monitoring_task->type \n";
                    if (isset($monitoring_task->timeout_in_minutes))
                        echo "monitoring_task[timeout_in_minutes]: $monitoring_task->timeout_in_minutes \n";
                    $tbl_monitoring_task_seq_of_test = new TblMonitoringTaskSeqOfTest();
                    $tbl_monitoring_task_seq_of_test->uint_job_mapping_index = $tbl_internal_queue->getWriteConnection()->lastInsertId();
                    $tbl_monitoring_task_seq_of_test->uint_monitor_task_seq_order = $monitorTestCount;
                    $tbl_monitor_test = TblTest::findFirst(
                        [
                            'columns'    => '*',
                            'conditions' => 'char_test_name = ?1 AND uint_test_type = ?2',
                            'bind'       => [
                                1 => $monitoring_task->name,
                                2 => $monitoring_task->type,
                            ]
                        ]
                    );
                    $tbl_monitoring_task_seq_of_test->uint_monitor_test_index = $tbl_monitor_test->uint_test_index; 

                    $tbl_monitoring_task_seq_of_test->uint_monitor_test_mode = $this->request->getPost("uint_monitor_test_mode");
                    $tbl_monitoring_task_seq_of_test->time_monitor_test_wait = $this->request->getPost("time_monitor_test_wait");
                    $tbl_monitoring_task_seq_of_test->datetime_monitor_test_start = $this->request->getPost("datetime_monitor_test_start");
                    $tbl_monitoring_task_seq_of_test->datetime_monitor_test_finish = $this->request->getPost("datetime_monitor_test_finish");
                    $tbl_monitoring_task_seq_of_test->uint_monitor_test_status = $this->request->getPost("uint_monitor_test_status");
                    $tbl_monitoring_task_seq_of_test->text_monitor_test_description = $this->request->getPost("text_monitor_test_description");


                    /*if (!$tbl_monitoring_task_seq_of_test->save()) {
                    }*/
                   $monitorTestCount++;
                }
            }

        $testCount++;
        }

    }
}

