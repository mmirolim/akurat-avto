<?php


class Clients extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $fullname;
     
    /**
     *
     * @var string
     */
    public $contactemail;
     
    /**
     *
     * @var string
     */
    public $contactphone;
     
    /**
     *
     * @var string
     */
    public $regdate;
     
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

    /**
     * current timestamp on each update
     * @var timestamp
     */
    public $when_updated;


    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Set has-many cars relationship
        $this->hasMany("id", "Cars", "owner_id");

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

    /**
     * Return the related "client's cars"
     * @param null $parameters
     * @return \Cars[]
     */
    public function getCars($parameters = null)
    {
        return $this->getRelated("Cars", $parameters);
    }

}
