<?php

class TblTest extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_test_index;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_test_type;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_test_mode;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $text_test_description;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $char_test_name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170313");
        $this->hasMany('uint_test_index', 'TblInternalQueue', 'uint_test_index', ['alias' => 'TblInternalQueue']);
        $this->hasMany('uint_test_index', 'TblMonitoringTaskSeqOfTest', 'uint_monitor_test_index', ['alias' => 'TblMonitoringTaskSeqOfTest']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_test';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblTest[]|TblTest
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblTest
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
