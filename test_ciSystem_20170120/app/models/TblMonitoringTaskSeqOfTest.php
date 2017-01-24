<?php

class TblMonitoringTaskSeqOfTest extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_monitror_test_mapping_index;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_internalQ_mapping_index;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_monitor_task_seq_order;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_monitor_test_index;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $time_monitor_test_wait;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $datetime_monitor_test_start;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $datetime_monitor_test_finish;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_monitor_test_status;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $text_error_description;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170120");
        $this->belongsTo('uint_monitor_test_index', '\TblTest', 'uint_test_index', ['alias' => 'TblTest']);
        $this->belongsTo('uint_internalQ_mapping_index', '\TblInternalQueue', 'uint_internalQ_mapping_index', ['alias' => 'TblInternalQueue']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_monitoring_task_seq_of_test';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblMonitoringTaskSeqOfTest[]|TblMonitoringTaskSeqOfTest
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblMonitoringTaskSeqOfTest
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
