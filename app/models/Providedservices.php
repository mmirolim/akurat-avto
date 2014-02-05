<?php

use Phalcon\Mvc\Model\Resultset;

class ProvidedServices extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $carId;
     
    /**
     *
     * @var integer
     */
    public $serviceId;

    /**
     *
     * @var integer
     */
    public $inMs;
     
    /**
     *
     * @var integer
     */
    public $masterId;

    /**
     *
     * @var string
     */
    public $startDate;
     
    /**
     *
     * @var string
     */
    public $finishDate;
     
    /**
     *
     * @var integer
     */
    public $milage;
     
    /**
     *
     * @var string
     */
    public $remindDate;
     
    /**
     *
     * @var integer
     */
    public $remindKm;

    /**
     *
     * @var integer
     */
    public $remindStatus;

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
            'car_id' => 'carId',
            'service_id' => 'serviceId',
            'in_ms' => 'inMs',
            'master_id' => 'masterId',
            'start_date' => 'startDate',
            'finish_date' => 'finishDate',
            'milage' => 'milage',
            'remind_date' =>  'remindDate',
            'remind_km'=>'remindKm' ,
            'remind_status' => 'remindStatus',
            'more_info' => 'moreInfo',
            'when_updated'=> 'whenUpdated'
        );
    }

    public function initialize()
    {
        //Define relationship wiht other Models
        $this->belongsTo("carId", "Cars", "id");
        $this->belongsTo("serviceId", "CarServices", "id");
        $this->belongsTo("masterId", "Employees", "id");

        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('whenUpdated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

    /**
     * Return the related "car"
     * @param null $parameters
     * @return \Cars[]
     */
    public function getCar($parameters=null)
    {
        return  $this->getRelated('Cars', $parameters);
    }

    /**
     * Return the related "employee"
     * @param null $parameters
     * @return \Employees[]
     */
    public function getEmployee($parameters=null)
    {
        return  $this->getRelated('Employees', $parameters);
    }

    /**
     * Return the related "car service"
     * @param null $parameters
     * @return \CarServices[]
     */
    public function getService($parameters=null)
    {
        return  $this->getRelated('CarServices', $parameters);
    }

    /**
     * Return status for date reminder set in
     * @return string
     */
    public function getRemindDateStatus()
    {
        if($this->remindStatus > 0) {
            if (time() - strtotime($this->remindDate) > 0) {
                $status = "alert";
            } else {
                $status = "ok";
            }
        } else {
            $status = 'disabled';
        }

        return $status;
    }

    /**
     * Return status for milage reminder set in service
     * according to related car milage and daily milage properties
     * @param null $milage related car milage
     * @param null $dailyMilage related car daily milage
     * @param null $milageDate related car last milage updated date
     * @return string
     */
    public function getRemindKmStatus($milage=null, $dailyMilage=null, $milageDate=null)
    {
        //Set status as undefined if you don't have enough data
        $status = 'undefined';
        //If remind status false then status disabled
        if ($this->remindStatus > 0) {
            //If null get from related model
            if (is_null($milage) || is_null($dailyMilage) ||is_null($milageDate)) {
                $car = $this->getCar();
                $milage = $car->milage;
                $dailyMilage = $car->dailyMilage;
                $milageDate = $car->milageDate;
            }
             //Get number of days between now and last milage updated
            $days = round((time() - strtotime($milageDate))/86400);
            //Get estimated km after last milage data update
            $kmSince = $days*$dailyMilage;

            if ($this->remindKm > 0 && ($this->getMilageRemind()  - ($milage + $kmSince)) < 0) {
                $status = "alert";
            } else {
                $status = "ok";
            }

        } else {
            $status = 'disabled';
        }

        return $status;
    }

    /**
     * Return milage reminder according to odometer
     * @return string
     */
    public function getMilageRemind()
    {
        //Show total milage as reminder
        return $this->remindKm + $this->milage;
    }
     
}
