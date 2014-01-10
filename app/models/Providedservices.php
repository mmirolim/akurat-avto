<?php


class Providedservices extends \Phalcon\Mvc\Model
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
    public $car_id;
     
    /**
     *
     * @var integer
     */
    public $work_id;
     
    /**
     *
     * @var integer
     */
    public $master_id;
     
    /**
     *
     * @var integer
     */
    public $cost;
     
    /**
     *
     * @var string
     */
    public $startdate;
     
    /**
     *
     * @var string
     */
    public $finishdate;
     
    /**
     *
     * @var integer
     */
    public $milage;
     
    /**
     *
     * @var string
     */
    public $reminddate;
     
    /**
     *
     * @var integer
     */
    public $remindkm;
     
    /**
     *
     * @var string
     */
    public $moreinfo;

    /**
     *
     * @var integer
     */
    public $remind;

    public function initialize()
    {
        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }
     
}
