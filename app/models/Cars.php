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
     * Vehicle identification number
     * @var string
     */
    public $vin;

    /**
     *
     * @var string
     */
    public $regNumber;
     
    /**
     *
     * @var integer
     */
    public $ownerId;
     
    /**
     *
     * @var integer
     */
    public $modelId;

    /**
     *
     * @var string
     */
    public $regDate;
     
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
    public $dailyMilage;
     
    /**
     *
     * @var string
     */
    public $moreInfo;

    /**
     * When last milage updated
     * @var date
     */
    public $milageDate;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    public $whenUpdated;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
         return array(
            'id' => 'id',
            'vin' => 'vin',
            'registration_number' => 'regNumber',
            'owner_id' => 'ownerId',
            'model_id' => 'modelId',
            'registered_date' => 'regDate',
            'year' => 'year',
            'milage' => 'milage',
            'daily_milage' =>  'dailyMilage',
            'more_info'=>'moreInfo' ,
            'milage_date' => 'milageDate',
            'when_updated'=> 'whenUpdated'
        );
    }


    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('whenUpdated'));

        //Set has-many cars relationship
        $this->hasMany("id", "ProvidedServices", "carId");

        //Insert date on creation for milage date
        //TODO test Behavior
        $this->addBehavior(new Timestampable(array(
            'beforeCreate' => array('field' => 'milageDate','format' => 'Y-m-d H:i:s')
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
    public function getProvidedServices($parameters = null)
    {
        return $this->getRelated("ProvidedServices", $parameters);
    }

}
