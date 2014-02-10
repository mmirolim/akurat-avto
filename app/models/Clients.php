<?php

use Phalcon\Db\RawValue;
use Phalcon\Mvc\Model\Behavior\Timestampable;


class Clients extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $_fullname;
     
    /**
     *
     * @var string
     */
    protected $_email;
     
    /**
     *
     * @var string
     */
    protected $_phone;
     
    /**
     *
     * @var string
     */
    protected $_regDate;
     
    /**
     *
     * @var string
     */
    protected $_info;

    /**
     *
     * @var integer
     */
    protected $_notify;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    protected $_whenUpdated;

    /**
     * @var Phalcon\Security
     */
    protected $_security;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values are their names in the application
        return array(
            'id' => '_id',
            'username' => '_username',
            'password' => '_password',
            'fullname' => '_fullname',
            'contact_email' => '_email',
            'contact_phone' => '_phone',
            'registered_date' =>  '_regDate',
            'more_info'=>'_info',
            'notification_status' => '_notify',
            'when_updated'=> '_whenUpdated'
        );
    }


    public function initialize()
    {
        //Get security service
        $this->_security = $this->getDI()->getSecurity();
        //Skips fields/columns on both INSERT/UPDATE operations
        //Column names have to be exact as in db table
        $this->skipAttributes(array('when_updated'));

        //Skips fields on CREATE, default is set to 1 (true)
        $this->skipAttributesOnCreate(array('notification_status'));

        //Set has-many cars relationship
        $this->hasMany("_id", "Cars", "_ownerId");

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());

        //Set registration date on creation
        $this->addBehavior(new Timestampable(
            array('beforeCreate' => array('field' => '_regDate','format' => 'Y-m-d'))
        ));
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

    public function setFullname($name)
    {
        $this->_fullname = $name;
    }

    public function getFullname()
    {
        return $this->_fullname;
    }

    public function setEmail($email)
    {
        //TODO validate email
        if (empty($email)) {
            $this->_email = new RawValue('default');
        } else {
            $this->_email = $email;
        }
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setRegDate()
    {
        $this->_regDate = new RawValue('default');
    }

    public function getRegDate()
    {
        return $this->_regDate;
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

    public function setNotify($bool)
    {
        //TODO validate should be 0 or 1
        $this->_notify = $bool;
    }

    public function getNotify()
    {
        return $this->_notify;
    }

    public function getWhenUpdated()
    {
        return $this->_whenUpdated;
    }

}

