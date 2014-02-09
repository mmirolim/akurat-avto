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
    public $contactEmail;
     
    /**
     *
     * @var string
     */
    public $contactPhone;
     
    /**
     *
     * @var string
     */
    public $regDate;
     
    /**
     *
     * @var string
     */
    public $moreInfo;

    /**
     *
     * @var integer
     */
    public $notify;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    public $whenUpdated;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values are their names in the application
        return array(
            'id' => 'id',
            'username' => 'username',
            'password' => 'password',
            'fullname' => 'fullname',
            'contact_email' => 'contactEmail',
            'contact_phone' => 'contactPhone',
            'registered_date' =>  'regDate',
            'more_info'=>'moreInfo',
            'notification_status' => 'notify',
            'when_updated'=> 'whenUpdated'
        );
    }


    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        //Column names have to be exact as in db table
        $this->skipAttributes(array('when_updated'));

        //Skips fields on CREATE, default is set to 1 (true)
        $this->skipAttributesOnCreate(array('notification_status'));

        //Set has-many cars relationship
        $this->hasMany("id", "Cars", "_ownerId");

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }


}
