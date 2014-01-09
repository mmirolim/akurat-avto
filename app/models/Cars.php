<?php


class Cars extends \Phalcon\Mvc\Model
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
    public $regnum;
     
    /**
     *
     * @var integer
     */
    public $owner_id;
     
    /**
     *
     * @var string
     */
    public $model;
     
    /**
     *
     * @var string
     */
    public $bodynumber;
     
    /**
     *
     * @var string
     */
    public $enginenumber;
     
    /**
     *
     * @var string
     */
    public $regdate;
     
    /**
     *
     * @var string
     */
    public $year;
     
    /**
     *
     * @var integer
     */
    public $milage;
     
    /**
     *
     * @var integer
     */
    public $dailymilage;
     
    /**
     *
     * @var string
     */
    public $moreinfo;

    /**
     * TODO ADD milage update date to estimate current milage
     */

    public function initialize()
    {
        //Set has-many cars relationship
        $this->hasMany("id", "Providedservices", "car_id");



    }

    /**
     * Return the related "services provided"
     * @param null $parameters
     * @return \Providedservices[]
     */
    public function getProvidedservices($parameters = null)
    {
        return $this->getRelated("Providedservices", $parameters);
    }

}
