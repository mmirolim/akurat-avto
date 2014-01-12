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

    /**
     * current timestamp on each update
     * @var timestamp
     */
    public $when_updated;

    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }
     
}
