<?php


class Roles extends \Phalcon\Mvc\Model
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
    public $role;
     
    /**
     *
     * @var string
     */
    public $moreinfo;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'role' => 'role', 
            'moreinfo' => 'moreinfo'
        );
    }

    public function initialize()
    {
        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
    }

}
