<?php


class Carservices extends \Phalcon\Mvc\Model
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
    public $carservice;
     
    /**
     *
     * @var string
     */
    public $moreinfo;

    public function initialize()
    {
        //Log model events
        $this->addBehavior(new Blamable());
    }
     
}
