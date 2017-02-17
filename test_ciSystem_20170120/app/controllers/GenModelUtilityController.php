<?php

/*
 *  general enums
 */
require_once (realpath('..') ."/app/library/CiRackStatus.php");

class GenModelUtilityController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    /*
     * Save model specified in parameter to configured database;
     */
    public static function saveModelFn($modelObject)
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
    public static function deleteModelFn($modelObject)
    {
        if (!$modelObject->delete()) {
            foreach ($modelObject->getMessages() as $message) {
                print_r($message);
            }
        }
    }

    /*
     * get Build type index.
     */
    public static function getBuildPlatformIndex($build_platform)
    {
        $ret = -1;
        switch ($build_platform) {
            case BoxPlatform::xwing :
                $ret = IntBoxPlatform::xwing;
                break;
            case BoxPlatform::falcon :
                $ret = IntBoxPlatform::falcon;
                break;
            case BoxPlatform::falconv2 :
                $ret = IntBoxPlatform::falconv2;
                break;
            case BoxPlatform::mr :
                $ret = IntBoxPlatform::mr;
                break;
            case BoxPlatform::amidala :
                $ret = IntBoxPlatform::amidala;
                break;
           default:
        }
        return $ret;
    }

    /*
     * get test type index.
     */
    public static function getTestTypeIndex($testType)
    {
        $ret = -1;
        switch ($testType) {
            case TestTypes::pythonCdiProc :
                $ret = IntTestTypes::pythonCdiProc;
                break;
            case TestTypes::shellCdiProc :
                $ret = IntTestTypes::shellCdiProc;
                break;
            case TestTypes::osterlyCdiProc :
                $ret = IntTestTypes::osterlyCdiProc;
                break;
            case TestTypes::stormIR :
                $ret = IntTestTypes::stormIR;
                break;
            case TestTypes::timeBased :
                $ret = IntTestTypes::timeBased;
                break;
           default:
        }
        return $ret;
    }

}

