<?php

use Phalcon\Mvc\Model\Validator\Uniqueness;


class CarModels extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $_id;
     
    /**
     *
     * @var integer
     */
    protected $_brandId;
     
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
            'brand_id' => '_brandId',
            'name' => '_name'
        );
    }

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field" => "_name",
                "message" => "This Model name already exists"
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

    public function setBrandId($brandId)
    {
        $this->_brandId = $brandId;
    }

    public function getBrandId()
    {
        return $this->_brandId;
    }


}
