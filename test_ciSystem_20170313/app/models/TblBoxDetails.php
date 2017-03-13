<?php

class TblBoxDetails extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_box_index;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $char_box_ip;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_box_platform;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=true)
     */
    public $char_mac;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database_20170313");
        $this->hasMany('uint_box_index', 'TblSlotConfig', 'uint_box_index', ['alias' => 'TblSlotConfig']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_box_details';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblBoxDetails[]|TblBoxDetails
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblBoxDetails
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
