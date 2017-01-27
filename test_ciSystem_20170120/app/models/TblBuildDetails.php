<?php

class TblBuildDetails extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_build_index;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $char_build_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_box_platform;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    public $char_build_md5sum;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_build_type;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $char_middleware_version;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170120");
        $this->hasMany('uint_build_index', 'TblJobQueue', 'uint_build_index', ['alias' => 'TblJobQueue']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_build_details';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblBuildDetails[]|TblBuildDetails
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblBuildDetails
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
