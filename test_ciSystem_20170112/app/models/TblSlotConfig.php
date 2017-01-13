<?php

class TblSlotConfig extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_slot_index;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $rack_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $rack_number;

    /**
     *
     * @var string
     * @Column(type="string", length=1, nullable=false)
     */
    public $bool_slot_availability;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $uint_box_index;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    public $uint_rack_type;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sample_ci_system_database");
        $this->hasMany('uint_slot_index', 'TblInternalQueue', 'uint_slot_index', ['alias' => 'TblInternalQueue']);
        $this->belongsTo('uint_box_index', '\TblBoxDetails', 'uint_box_index', ['alias' => 'TblBoxDetails']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tbl_slot_config';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblSlotConfig[]|TblSlotConfig
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblSlotConfig
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
