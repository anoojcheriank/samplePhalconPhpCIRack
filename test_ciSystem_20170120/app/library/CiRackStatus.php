<?php
class CiRackStatus
{

}

/*
 * Enum status to shoe the slot availability.
 */
abstract class SlotAvailability
{
    const NotAvailable = 0;
    const Available = 1;
}

/*
 * Enum status to show the Job state
 */
abstract class JobState
{
    const Scheduled = 0;
    const InProgress = 1;
    const Completed = 1;
}

/*
 * Enum status for box platform
 */
abstract class BoxPlatform
{
    const xwing = "xwing";
    const falcon = "falcon";
    const falconv2 = "falconv2";
    const mr = "mr";
    const amidala = "amidala";
}

/*
 * Enum status for box platform
 */
abstract class IntBoxPlatform
{
    const xwing = 0;
    const falcon = 1;
    const falconv2 = 2;
    const mr = 3;
    const amidala = 4;
}

/*
 * Enum status to show the Job state
 */
abstract class TestTypes
{
    const pythonCdiProc = "pythonCdiProc";
    const shellCdiProc = "shellCdiProc";
    const osterlyCdiProc = "osterlyCdiProc";
    const stormIR = "stormIR";
    const timeBased = "timeBased";
}



/*
 * Enum status to show the Job state
 */
abstract class IntTestTypes
{
    const pythonCdiProc = 0;
    const shellCdiProc = 1;
    const osterlyCdiProc = 2;
    const stormIR = 3;
    const timeBased = 4;
}



