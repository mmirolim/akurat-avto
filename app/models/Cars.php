<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;

class Cars extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var string
     */
    public $regnum;
     
    /**
     *
     * @var integer
     */
    public $owner_id;
     
    /**
     *
     * @var string
     */
    public $model;
     
    /**
     *
     * @var string
     */
    public $bodynumber;
     
    /**
     *
     * @var string
     */
    public $enginenumber;
     
    /**
     *
     * @var string
     */
    public $regdate;
     
    /**
     *
     * @var string
     */
    public $year;
     
    /**
     *
     * @var integer
     */
    public $milage;
     
    /**
     *
     * @var integer
     */
    public $dailymilage;
     
    /**
     *
     * @var string
     */
    public $moreinfo;

    /**
     * When last milage updated
     * @var date
     */
    public $mlgdate;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    public $when_updated;


    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Set has-many cars relationship
        $this->hasMany("id", "Providedservices", "car_id");

        //Insert date on creation for milage date
        //TODO test Behavior
        $this->addBehavior(new Timestampable(array(
            'beforeCreate' => array('field' => 'mlgdate','format' => 'Y-m-d')
        )));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());

    }


    /**
     * Return the related "services provided"
     * @param null $parameters
     * @return \Providedservices[]
     */
    public function getProvidedservices($parameters = null)
    {
        return $this->getRelated("Providedservices", $parameters);
    }

}
