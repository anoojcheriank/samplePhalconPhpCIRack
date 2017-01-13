<?php
/**
 * Created by PhpStorm.
 * User: rkaduvakkancheri
 * Date: 28/12/16
 * Time: 14:54
 */

function cidt_getstatus($JobId, $app){
    echo "CIDT status of ".$JobId." is working \n";
}

function cidt_getalldata() use ($app){
    $phql = "SELECT * FROM citesting\\Cidt ORDER BY Priority";
    $cidt_tests = $app->modelsManager->executeQuery($phql);

    $data = [];

    foreach ($cidt_tests as $tests) {
        $data[] = [
            "Jobid" => $tests->JobId,
            "Platform" => $tests->Platform,
            "JobNumber" => $tests->JobNumber,
            "JobName" => $tests->JobName,
        ];
    }

    echo json_encode($data);
    echo "This is working may be no data";
}