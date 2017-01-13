<?php
/**
 * Created by PhpStorm.
 * User: rkaduvakkancheri
 * Date: 19/12/16
 * Time: 10:34
 */
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Config;
use Phalcon\Http\Response;

use Jenkins;

define("ROOT_PATH", "/var/www/html/cisystem/citesting");

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH ."/app/controllers/",
        ROOT_PATH . "/app/models/",
        ROOT_PATH ."/app/config/",
        ROOT_PATH ."/app/library/",
    ]
);


$loader->registerNamespaces(
    [
        "citesting" => ROOT_PATH . "/app/models/",
    ]
);


$loader->register();

#use cidt_api;

// Create a DI
$di = new FactoryDefault();

//Setup config file
$di->set(
    "config",
    function () {
        return new ConfigIni(ROOT_PATH ."/app/config/"."config.ini");
        #$configData = require ROOT_PATH ."/app/config/"."config.ini";
        #$config = new Config($configData);
        #return $config;
    }
);

// Setup the view component
$di->set(
    "view",
    function () {
        $view = new View();

        $view->setViewsDir(ROOT_PATH ."/app/views/");

        return $view;
    }
);

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    "url",
    function () {
        $url = new UrlProvider();

        $url->setBaseUri("/cisystem/citesting/");
        #$url->setBaseUri("/");

        return $url;
    }
);

$di->set(
    "db",
    function (){
        $loc_config = new ConfigIni(ROOT_PATH ."/app/config/"."config.ini");
        #$loc_config = $this->config;
        return new PdoMysql(
            [
            "host"     => $loc_config->database->host,
            "username" => $loc_config->database->username,
            "password" => $loc_config->database->password,
            "dbname"   => $loc_config->database->dbname,

            ]
        );
    },
    true // shared
);

use Phalcon\Mvc\Micro;

try {
    $app = new Micro($di);

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo "This is crazy, but this page was not found! <br>"." \n";
    });

    $app->get(
        "/",
        function()  use ($app) {
            echo "<h1>".$app->config->application->name."</h1>";
            echo "<h3>"."This is root page Please use Apis". "</h3>";
        }
    );

    //echo "$app";
    // Retrieves all robots
    $app->get(
        "/api/cidt",
        function () use ($app){
            $phql = "SELECT * FROM citesting\\Cidt ORDER BY Priority";
            $cidt_tests = $app->modelsManager->executeQuery($phql);

            $data = [];

            foreach ($cidt_tests as $tests) {
                $data[] = [
                    "Jobid" => $tests->JobId,
                    "Platform" => $tests->Platform,
                    "JobNumber" => $tests->JobNumber,
                    "JobName" => $tests->JobName,
                    "Priority" => $tests->Priority,
                    "Status" => $tests->Status
                ];
            }

            echo json_encode($data);
        }
            #json_decode(json_encode($data));
            #$decoded = $data;
            #echo "Platform : " . $decoded[0]["Platform"]  . '<br>';
            #echo "Jobid : ". $decoded[0]["Jobid"]. '<br>';
            #echo "JobNumber : " . $decoded[0]["JobNumber"]. '<br>';
            #echo "JobName : " . $decoded[0]["JobName"]. '<br>';
    );

    // Searches for robots with $name in their name
    $app->get(
        "/api/cidt/status/{jobId}",
        function ($JobId) use ($app){
            $phql = "SELECT * FROM citesting\\Dmsresult WHERE JobId = :JobId:";
            $cidt_tests = $app->modelsManager->executeQuery(
                $phql,
                [
                    "JobId" => $JobId
                ]
            );

            $data = [];

            foreach ($cidt_tests as $tests) {
                $data[] = [
                    "Jobid" => $tests->JobId,
                    "Platform" => $tests->Platform,
                    "Status" => $tests->Status,
                    "ErrorMessage" => $tests->ErrorMessage,
                    "Percentage" => $tests->Percentage,
                    "STBName" => $tests->STBName,
                ];
            }

            echo json_encode($data);
        }
    );

    // Add new new DMS Test
    $app->post(
        "/api/cidt",
        function () use ($app){
            try {

                $loc_config = new ConfigIni(ROOT_PATH ."/app/config/"."config.ini");

                $init_status = "WAITING";
                $default_priority = 10;
                $default_test_name = "CISystem_DMS_Test";
                $default_job_number = 10;
                $Priority = $default_priority;

                $phql = "INSERT INTO citesting\\Cidt  " .
                    " VALUES (:JobId:, :Platform:, :Priority:, :Status:, :JobNumber:, :JobName:)";

                $test = $app->request->getJsonRawBody();

                try {
                    $Priority = $test->Priority;
                }catch (Exception $e) {
                    $Priority = $default_priority;
                }

                $status = $app->modelsManager->executeQuery($phql,
                    [
                        "JobId" => $test->JobId,
                        "Platform" => $test->Platform,
                        "Priority" => $Priority,
                        "Status" => $init_status,
                        "JobNumber" => $default_job_number,
                        "JobName" => $default_test_name,
                    ]
                );

                #echo "CIDT POST is working for JobId = " . $test->JobId . " and Platform = " . $test->Platform . "  <br>" . " \n";

                // Create a response
                $response = new Response();

                // Check if the insertion was successful
                if ($status->success() === true) {
                    $response->setJsonContent(
                        [
                            "status" => "OK",
                            "data" => $test,
                        ]
                    );
                } else {
                    // Change the HTTP status
                    $response->setStatusCode(409, "Conflict");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "ERROR",
                            "messages" => $errors,
                        ]
                    );
                }
                return $response;

            }catch (Exception $e) {
                echo 'Caught exception: '.  $e->getMessage(). "\n";
            }

        }

    );

    // API to trigger the Test
    $app->post(
        "/api/cidt/starttest",
        function () use ($app){

            #Main logic to start DMS test has placed here

            $loc_config = new ConfigIni(ROOT_PATH ."/app/config/"."config.ini");

            $phql = "SELECT * FROM citesting\\Dmsstbstatus WHERE IsAvailable = :availability:";
            $dms_stb_available = $app->modelsManager->executeQuery($phql, [
                "availability" => 1
            ]);

            $data = [];

            foreach ($dms_stb_available as $stb) {
                #Launch Test for first available platform and STB
                $cidt_get_test = "SELECT * FROM citesting\\Cidt WHERE Platform = :Platform: and Status = :Status: ORDER BY Priority LIMIT 1";
                $cidt_test = $app->modelsManager->executeQuery($cidt_get_test, [
                    "Platform" => $stb->Platform,
                    "Status" => "WAITING",
                ]);

                #Parse only one raw break after processing
                foreach ($cidt_test as $test) {
                    $cidt_get_test_param = "SELECT * FROM citesting\\Stbinfo WHERE STBName = :STBName: LIMIT 1";
                    $cidt_parameter_list = $app->modelsManager->executeQuery($cidt_get_test_param, [
                        "STBName" => $stb->STBName
                    ]);

                    foreach ($cidt_parameter_list as $cidt_parameter) {
                        /*
                        $url_link = $loc_config->host->JenkinsRootUrl . "job/" . $cidt_parameter->JobName . "/build?";
                        $data = "Jobid=" . $test->JobId . "&Platform=" . $test->Platform . "&STBName=" . $cidt_parameter->STBName .
                            "&STBID=" . $cidt_parameter->STBID . "&STBIP=" . $cidt_parameter->IP . "&STBCardNum=" . $cidt_parameter->CardNumber;
                        $ch = curl_init();

                        $url = $url_link.$data;
                        curl_setopt($ch, CURLOPT_URL, $url);

                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        #curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                        $TestInfo[] = [
                            "Url" => $url,
                            "Data" => $data,
                            "JobName" => $cidt_parameter->JobName,
                            "JobId" => $test->JobId,
                            "Platform" => $test->Platform,
                            "STBName" => $cidt_parameter->STBName,
                            "STBID" => $cidt_parameter->STBID,
                            "STBIP" => $cidt_parameter->IP,
                            "STBCardNum" => $cidt_parameter->CardNumber,
                        ];

                        echo json_encode($TestInfo) . "\n\n";


                        // $output contains the output string
                        $output = curl_exec($ch);
                        curl_close($ch);

                        #var_dump($ch);
                        #echo $output;
                        // close curl resource to free up system resources
                        */
                        $jenkins = new Jenkins($loc_config->host->JenkinsRootUrl);
                        #echo "Start the test "."\n";
                        #echo json_encode($data) . "\n\n";

                        #Update STB available status to false
                        $phql = "UPDATE citesting\\Dmsstbstatus SET IsAvailable = :availability: WHERE STBName = :STBName:";
                        $status = $app->modelsManager->executeQuery($phql, [
                            "availability" => 1,
                            "STBName" => $stb->STBName,
                        ]);

                        $response = new Response();

                        // Check if the insertion was successful
                        if ($status->success() !== true) {
                            // Change the HTTP status
                            $response->setStatusCode(409, "Conflict");

                            $errors = [];

                            foreach ($status->getMessages() as $message) {
                                $errors[] = $message->getMessage();
                            }

                            $response->setJsonContent(
                                [
                                    "status" => "ERROR",
                                    "messages" => $errors,
                                ]
                            );

                            return $response;
                        }
                    }
                }
            }

            #echo json_encode($data);

            #echo "API to START the Test from cidt table \n";
        }
    );

    $app->handle();

} catch (\Exception $e) {

    echo "Exception: ", $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}

/**
$application = new Application($di);

try {
    echo $application->handle()->getContent();
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
 ***/
