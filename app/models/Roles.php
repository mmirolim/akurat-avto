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
    public $moreInfo;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
        return array(
        'id' => 'id',
        'role' => 'role',
        'more_info' => 'moreInfo',

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
