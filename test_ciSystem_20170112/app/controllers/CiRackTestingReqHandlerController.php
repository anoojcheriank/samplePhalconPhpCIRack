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
        $tbl_job_queue->uint_job_id = $jsonJob->job_id;
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

        $tbl_job_queue->uint_build_index = $tbl_build_detail->getWriteConnection()->lastInsertId();;
        /*if (!$tbl_job_queue-->save()) {
            foreach ($tbl_job_queue-->getMessages() as $message) {
                print_r($message);
            }
        }*/
        

        $tests_details=$jsonJob->tests_details;
        foreach ($tests_details as $test) 
        {
            echo "test[name]: $test->name \n";
            echo "test[type]: $test->type \n";
            if (isset($test->monitoring_tasks))
            {
                $monitoring_tasks=$test->monitoring_tasks;
                foreach ($monitoring_tasks as $monitoring_task) 
                {
                    echo "monitoring_task[name]: $monitoring_task->name \n";
                    echo "monitoring_task[type]: $monitoring_task->type \n";
                    if (isset($monitoring_task->timeout_in_minutes))
                        echo "monitoring_task[timeout_in_minutes]: $monitoring_task->timeout_in_minutes \n";
                }
            }
        }

    }
}

