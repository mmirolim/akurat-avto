<?php

use Phalcon\Db\RawValue;

class Roles extends \Phalcon\Mvc\Model
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
    protected $_role;
     
    /**
     *
     * @var string
     */
    protected $_info;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
        return array(
        'id' => '_id',
        'role' => '_role',
        'more_info' => '_info',

        );
    }
     

    public function initialize()
    {
        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setRole($title)
    {
        $this->_role = $title;
    }

    public function getRole()
    {
        return $this->_role;
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
}
