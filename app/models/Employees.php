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
    public $roleId;
     
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
    public $moreInfo;
     
    /**
     *
     * @var string
     */
    public $worksSince;

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
            'username' => 'username',
            'password' => 'password',
            'role_id' => 'roleId',
            'fullname' => 'fullname',
            'job' => 'job',
            'contacts' => 'contacts',
            'registered_date' =>  'regDate',
            'more_info'=>'moreInfo',
            'works_since' => 'worksSince',
            'when_updated'=> 'whenUpdated'
        );
    }

    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('whenUpdated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }
}
