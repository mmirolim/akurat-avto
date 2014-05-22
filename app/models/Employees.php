<?php

use Phalcon\Db\RawValue;

class Employees extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $_id;
     
    /**
     *
     * @var string
     */
    protected $_username;
     
    /**
     *
     * @var string
     */
    protected $_password;
     
    /**
     *
     * @var integer
     */
    protected $_roleId;
     
    /**
     *
     * @var string
     */
    protected $_fullname;
     
    /**
     *
     * @var string
     */
    protected $_job;
     
    /**
     *
     * @var string
     */
    protected $_contacts;
     
    /**
     *
     * @var string
     */
    protected $_info;
     
    /**
     *
     * @var string
     */
    protected $_worksSince;

    /**
     * current timestamp on each update
     * @var timestampdate
     */
    protected $_whenUpdated;

    /**
     * @var Phalcon\Security
     */
    protected $_security;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
        return array(
            'id' => '_id',
            'username' => '_username',
            'password' => '_password',
            'role_id' => '_roleId',
            'fullname' => '_fullname',
            'job' => '_job',
            'contacts' => '_contacts',
            'more_info'=>'_info',
            'works_since' => '_worksSince',
            'when_updated'=> '_whenUpdated'
        );
    }

    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Set has-many cars relationship
        $this->hasMany("_id", "ProvidedServices", "masterId");

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setUsername($name)
    {
        //TODO validate to uniqueness
        $this->_username = $name;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setPassword($pass)
    {
        //TODO add validation to password
        if (!empty($pass)) {
            $this->_password = $this->_security->hash($pass);
        }
    }

    public function getPassword()
    {
        return $this->_password;
    }
    public function setRoleId($id)
    {
        //TODO validate one of roles
        $this->_roleId = $id;
    }

    public function getRoleId()
    {
        return $this->_roleId;
    }

    public function setFullname($name)
    {
        $this->_fullname = $name;
    }

    public function getFullname()
    {
        return $this->_fullname;
    }

    public function setJob($job)
    {
        $this->_job = $job;
    }

    public function getJob()
    {
        return $this->_job;
    }

    public function setContacts($contact)
    {
        $this->_contacts = $contact;
    }

    public function getContacts()
    {
        return $this->_contacts;
    }

    public function setWorksSince($date)
    {
        //TODO must be valid date
        $this->_worksSince = $date;
    }

    public function getWorksSince()
    {
        return $this->_worksSince;
    }

    public function setInfo($info)
    {
        if (empty($info)) {
            $this->_info = new RawValue('default');
        } else {
            $this->_info = $info;
        }
    }

    public function getInfo()
    {
        return $this->_info;
    }

    public function getWhenUpdated()
    {
        return $this->_whenUpdated;
    }

    /**
     * Return "employees" in array by id
     * @param null $parameters
     * @return \Employees[]
     */
    public static function inArrayById($parameters=null)
    {
        $employees = Employees::find($parameters)->toArray();

        //Create array with keys from employees ids
        $employeesById = array();
        foreach ($employees as $employee) {
            $employeesById[$employee['_id']] = $employee;
        }

        return $employeesById;
    }
}
