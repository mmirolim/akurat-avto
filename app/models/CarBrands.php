<?php

use Phalcon\Mvc\Model\Validator\Uniqueness;


class CarBrands extends \Phalcon\Mvc\Model
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
    protected $_name;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => '_id',
            'name' => '_name'
        );
    }

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field" => "_name",
                "message" => "This Brand name already exists"
            )
        ));
        return $this->validationHasFailed() != true;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

}
