<?php




class CarModels extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $brandId;
     
    /**
     *
     * @var string
     */
    public $name;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'brand_id' => 'brandId',
            'name' => 'name'
        );
    }

}
