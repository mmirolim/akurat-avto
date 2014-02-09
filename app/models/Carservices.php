<?php

use Phalcon\Db\RawValue;

class CarServices extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $_id;
     
    /**
     *
     * @var string
     */
    protected $_service;

    /**
     *
     * @var string
     */
    protected $_moreInfo;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    protected $_whenUpdated;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
        return array(
            'id' => '_id',
            'service' => '_service',
            'more_info' => '_moreInfo',
            'when_updated'=> '_whenUpdated'
        );
    }

    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setService($name)
    {
        $this->_service = $name;
    }

    public function getService()
    {
        return $this->_service;
    }

    public function setMoreInfo($info)
    {
        if (empty($info)) {
            $this->_moreInfo = new RawValue('default');
        } else {
            $this->_moreInfo = $info;
        }
    }

    public function getMoreInfo()
    {
        return $this->_moreInfo;
    }

    public function getWhenUpdated()
    {
        return $this->_whenUpdated;
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
            $servicesById[$service['_id']] = $service;
        }

        return $servicesById;
    }
     
}
