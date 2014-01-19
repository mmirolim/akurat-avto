<?php


class CarServices extends \Phalcon\Mvc\Model
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
    public $service;

    /**
     *
     * @var string
     */
    public $moreInfo;

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
            'service' => 'service',
            'more_info' => 'moreInfo',
            'when_updated'=> 'whenUpdated'
        );
    }

    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('whenUpdated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

    /**
     * Return "car services" in array by id
     * @param null $parameters
     * @return \CarServices[]
     */
    public static function inArrayById($parameters=null)
    {
        $services = CarServices::find($parameters)->toArray();

        //Create array with keys from employees ids
        $servicesById = array();
        foreach ($services as $service) {
            $servicesById[$service['id']] = $service;
        }

        return $servicesById;
    }
     
}
