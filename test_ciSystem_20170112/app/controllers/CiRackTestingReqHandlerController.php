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
   
    public function scheduleJob($json)
    {
        #print_r($jsonJob);
        $jsonJob=$json->__job;
        echo "job_id: $jsonJob->job_id \n";
        echo "priority: $jsonJob->priority \n";
        echo "number_of_boxes: $jsonJob->number_of_boxes \n";
        $build_details=$jsonJob->build_details;
        echo "build_details[build_name]: $build_details->build_name \n";
        echo "build_details[build_platform]: $build_details->build_platform \n";
        echo "build_details[build_type]: $build_details->build_type \n";
        echo "build_details[Middleware_version]: $build_details->Middleware_version \n";
        $tests_details=$jsonJob->tests_details;
        foreach ($tests_details as $test) 
        {
            echo "test[name]: $test->name \n";
            echo "test[type]: $test->type \n";
            $monitoring_tasks=$test->monitoring_tasks;
            foreach ($monitoring_tasks as $monitoring_task) 
            {
                echo "monitoring_task[name]: $monitoring_task->name \n";
                echo "monitoring_task[type]: $monitoring_task->type \n";
                echo "monitoring_task[timeout_in_minutes]: $monitoring_task->timeout_in_minutes \n";
            }
        }
    }
}

