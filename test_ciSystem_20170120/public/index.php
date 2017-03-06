<?php
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /*
     * Code for immediate printing.
     */
    ob_implicit_flush(false);
    ob_start();

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . "/config/services.php";

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    //echo $application->handle()->getContent();

  
    /**
     * Micro application for request handler
     */
    $app = new Phalcon\Mvc\Micro($di);

    /**
     * Invalid page access
     */
    $app->notFound(function () use ($app) {
        //$app->response->setStatusCode(404, "Not Found")->sendHeaders();
        //echo "This is crazy, but this page was not found! <br>"." \n";
       
    });

    /**
     * Get request
     */
    $app->get(
        "/ciRack",
        function () use ($app, $application){
            try {
                  //echo $application->handle()->getContent();

              
            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }
    );

    /**
     * listJobs webservice
     */
    $app->get(
        "/ciRack/listJobs",
        function () use ($app){
            try {

              $ciRackHandle = new CiRackTestingReqHandlerController();
              //echo (new \Phalcon\Debug\Dump())->variable($ciRackHandle, "ciRackHandle");
              $ciRackHandle->listAllJobIds();

            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }
    );
   
    /**
     * cancelJob webservice
     */
    $app->post(
        "/ciRack/cancelJob",
        function () use ($app){
            try {
              $jobId = $app->request->getRawBody();
              echo "jobId: $jobId \n";
              $ciRackHandle = new CiRackTestingReqHandlerController();
              //echo (new \Phalcon\Debug\Dump())->variable($ciRackHandle, "ciRackHandle");
              $ciRackHandle->cancelJob($jobId);

            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }
    );


    /**
     * scheduleJob webservice
     */
    $app->post(
        "/ciRack/scheduleJob",
        function () use ($app){
            try {

              $jsonJob = $app->request->getJsonRawBody();
              $ciRackHandle = new CiRackTestingReqHandlerController();
              //echo (new \Phalcon\Debug\Dump())->variable($ciRackHandle, "ciRackHandle");
              $ciRackHandle->scheduleJob($jsonJob);

            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }
    );

    /**
     * processJob webservice
     */
    $app->post(
        "/ciRack/processJobQueue",
        function () use ($app){
            try {

              $ciRackHandle = new CiRackTestingReqHandlerController();
              //echo (new \Phalcon\Debug\Dump())->variable($ciRackHandle, "ciRackHandle");
              $ciRackHandle->processJobQueue();

            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }
    );
 
    /**
     * processJob webservice
     */
    $app->post(
        "/ciRack/test",
        function () use ($app){
            try {
           
            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }
    );

    
   /*
    * Start web service
    */
   $app->handle();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
