<?php
namespace citesting;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;

class Dmsresult extends Model
{

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=false)
     */
    public $JobId;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=false)
     */
    public $Platform;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=false)
     */
    public $Status;

    /**
     *
     * @var string
     * @Column(type="string", length=300, nullable=true)
     */
    public $ErrorMessage;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $Percentage;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $STBName;

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
        return 'dmsresult';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Dmsresult[]|Dmsresult
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Dmsresult
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @return bool
     */
    public function validation()
    {

        return true;
    }
}
