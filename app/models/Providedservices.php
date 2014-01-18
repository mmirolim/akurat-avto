<?php


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

    /*
     * Return return status of reminder by km
     * @var string
     */
    public $remindDateStatus;

    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('whenUpdated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

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
     
}
