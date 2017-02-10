<?php

/*
 * General status enum collection
 */
require realpath('..') ."/app/library/CiRackStatus.php";


class CiRackTestingSlotController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }
    
    public function getBoxInSlot($tbl_slot)
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
    public function getAvailableSlot($build_platform)
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
}

