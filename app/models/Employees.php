<?php


class Employees extends \Phalcon\Mvc\Model
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
    public $username;
     
    /**
     *
     * @var string
     */
    public $password;
     
    /**
     *
     * @var integer
     */
    public $role_id;
     
    /**
     *
     * @var string
     */
    public $fullname;
     
    /**
     *
     * @var string
     */
    public $job;
     
    /**
     *
     * @var string
     */
    public $contacts;
     
    /**
     *
     * @var string
     */
    public $moreinfo;
     
    /**
     *
     * @var string
     */
    public $date;

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
