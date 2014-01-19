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

    //Get related Car
    public function getCar($parameters=null)
    {
        return  $this->getRelated('Cars', $parameters);
    }

    //Get related Master
    public function getEmployee($parameters=null)
    {
        return  $this->getRelated('Employees', $parameters);
    }

    //Get related Service
    public function getService($parameters=null)
    {
        return  $this->getRelated('CarServices', $parameters);
    }

    //Get status for date reminder set in service
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
    //Get status for milage reminder set in service
    public function getRemindKmStatus()
    {
        if($this->remindStatus > 0) {

            $car = $this->getCar();

            if (!is_null($car->milage) && !is_null($car->dailyMilage)) {
                if ($car->milageDate > 0 && $car->dailyMilage > 0) {
                    //Get number of days between now and last milage updated
                    $days = round((time() - strtotime($car->milageDate))/86400);
                    //Get estimated km after last milage data update
                    $kmSince = $days*$car->dailyMilage;

                    if ($this->remindKm > 0 && ($this->getMilageRemind()  - ($car->milage + $kmSince)) < 0) {
                        $status = "alert";
                    } else {
                        $status = "ok";
                    }
                }
            }
        } else {
            $status = 'disabled';
        }

        return $status;
    }

    public function getMilageRemind()
    {
        return $this->remindKm + $this->milage;
    }
     
}
