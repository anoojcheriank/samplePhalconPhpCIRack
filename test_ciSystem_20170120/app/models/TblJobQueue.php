<?php

class TblJobQueue extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_job_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_priority;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_number_of_boxes;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_build_index;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    public $uint_job_status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170120");
        $this->hasMany('uint_job_id', 'TblInternalQueue', 'uint_job_id', ['alias' => 'TblInternalQueue']);
        $this->belongsTo('uint_build_index', '\TblBuildDetails', 'uint_build_index', ['alias' => 'TblBuildDetails']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_job_queue';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblJobQueue[]|TblJobQueue
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblJobQueue
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
