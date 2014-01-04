<?php


class Clients extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $fullname;
     
    /**
     *
     * @var string
     */
    public $contactemail;
     
    /**
     *
     * @var string
     */
    public $contactphone;
     
    /**
     *
     * @var string
     */
    public $regdate;
     
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
            'username' => 'username', 
            'password' => 'password', 
            'fullname' => 'fullname', 
            'contactemail' => 'contactemail', 
            'contactphone' => 'contactphone', 
            'regdate' => 'regdate', 
            'moreinfo' => 'moreinfo'
        );
    }

}
