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
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'username' => 'username', 
            'password' => 'password', 
            'role_id' => 'role_id', 
            'fullname' => 'fullname', 
            'job' => 'job', 
            'contacts' => 'contacts', 
            'moreinfo' => 'moreinfo', 
            'date' => 'date'
        );
    }

    public function initialize()
    {
        //Log model events
        $this->addBehavior(new Blamable());
    }
}
