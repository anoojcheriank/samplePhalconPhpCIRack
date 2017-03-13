<?php

class TblJobExecutionStatus extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $unit_job_execution_status;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_job_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_slot_index;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $datetime_test_start;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $datetime_test_finish;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_execution_status;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $text_msg;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170313");
        $this->belongsTo('uint_slot_index', '\TblSlotConfig', 'uint_slot_index', ['alias' => 'TblSlotConfig']);
        $this->belongsTo('uint_job_id', '\TblJobQueue', 'uint_job_id', ['alias' => 'TblJobQueue']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_job_execution_status';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblJobExecutionStatus[]|TblJobExecutionStatus
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblJobExecutionStatus
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
