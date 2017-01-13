<?php
namespace citesting;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;

class Stbinfo extends Model
{

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $Platform;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=45, nullable=false)
     */
    public $STBName;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=false)
     */
    public $IP;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $MAC;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=false)
     */
    public $STBID;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=false)
     */
    public $CardNumber;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=false)
     */
    public $RackName;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $SlotNumber;

    /**
     *
     * @var string
     * @Column(type="string", length=5, nullable=false)
     */
    public $ComPort;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $JobName;

    /**
     * @return bool
     */
    public function validation()
    {

        /*

        // Robot name must be unique
        $this->validate(

            new Uniqueness(
                [
                    "field"   => "JobId",
                    "message" => "The JobId must be unique",
                ]
            )


        );

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true) {
            return false;
        }
        */
        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cisystem");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'stbinfo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stbinfo[]|Stbinfo
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stbinfo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
