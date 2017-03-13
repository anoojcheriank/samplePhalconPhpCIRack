<?php

class TblInternalQueue extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_internalQ_mapping_index;

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
    public $uint_seq_order;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_test_index;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170313");
        $this->hasMany('uint_internalQ_mapping_index', 'TblMonitoringTaskSeqOfTest', 'uint_internalQ_mapping_index', ['alias' => 'TblMonitoringTaskSeqOfTest']);
        $this->belongsTo('uint_test_index', '\TblTest', 'uint_test_index', ['alias' => 'TblTest']);
        $this->belongsTo('uint_job_id', '\TblJobQueue', 'uint_job_id', ['alias' => 'TblJobQueue']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_internal_queue';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblInternalQueue[]|TblInternalQueue
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblInternalQueue
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
