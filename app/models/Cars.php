<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Db\RawValue;

class Cars extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $_id;

    /**
     * Vehicle identification number
     * @var string
     */
    protected $_vin;

    /**
     *
     * @var string
     */
    protected $_regNumber;
     
    /**
     *
     * @var integer
     */
    protected $_ownerId;
     
    /**
     *
     * @var integer
     */
    protected $_modelId;

    /**
     *
     * @var string
     */
    protected $_regDate;
     
    /**
     *
     * @var string
     */
    protected $_year;
     
    /**
     *
     * @var integer
     */
    protected $_milage;
     
    /**
     *
     * @var integer
     */
    protected $_dailyMilage;
     
    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $_info;

    /**
     * When last milage updated
     * @var date
     */
    protected $_milageDate;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    protected $_whenUpdated;

    /**
     *if setters have exception set to false
     * @var boolean
     */
    protected $_valid;

    /**
     * @var Phalcon\Flash\Session
     */
    private $_flashSession;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
         return array(
            'id' => '_id',
            'vin' => '_vin',
            'registration_number' => '_regNumber',
            'owner_id' => '_ownerId',
            'model_id' => '_modelId',
            'registered_date' => '_regDate',
            'year' => '_year',
            'milage' => '_milage',
            'daily_milage' =>  '_dailyMilage',
            'more_info'=>'_info' ,
            'milage_date' => '_milageDate',
            'when_updated'=> '_whenUpdated'
        );
    }


    public function initialize()
    {
        //Get flash session service
        $this->_flashSession = $this->getDI()->getFlashSession();
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Set has-many cars relationship
        $this->hasMany("_id", "ProvidedServices", "_carId");

        //Set belongs to model relationship
        $this->belongsTo("_modelId", "CarModels", "_id");

        //Set belongs to model relationship
        $this->belongsTo("_ownerId", "Clients", "_id");

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());

        $this->addBehavior(new Timestampable(
            array('beforeCreate' => array('field' => '_regDate','format' => 'Y-m-d'))
        ));

    }

    public function validation()
    {
        if ($this->_valid === false) {
            return false;
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setVin($vin)
    {
        $this->_vin = $vin;
    }

    public function getVin()
    {
        return $this->_vin;
    }

    public function setRegNumber($regnum)
    {
        $this->_regNumber = $regnum;
    }

    public function getRegNumber()
    {
        return $this->_regNumber;
    }

    /**
     * Set _ownerId according to username
     * @param $username
     * @throws \InvalidArgumentException
     */
    public function setOwner($username)
    {
        $owner = Clients::findFirst(array(
            '_username = ?0',
            'bind' => [$username]
        ));
        if ($owner != false) {
            $this->_ownerId = $owner->getId();
        } else {
            $this->_valid = false;
            $this->_flashSession->error("The is no client with username '$username'");
        }

    }

    public function setOwnerId($id)
    {
        $this->_ownerId = $id;
    }

    public function getOwnerId()
    {
        return $this->_ownerId;
    }

    public function setModelId($id)
    {
        $this->_modelId = $id;
    }

    public function getModelId()
    {
        return $this->_modelId;
    }

    public function setRegDate()
    {
        $this->_regDate = new RawValue('default');
    }
    public function getRegDate()
    {
        return $this->_regDate;
    }

    public function setYear($year)
    {
        $this->_year = $year;
    }

    public function getYear()
    {
        return $this->_year;
    }

    public function setMilage($milage)
    {
        //TODO set _milageDate when milage changes
        if(intval($milage) != intval($this->_milage)) {
            $this->_milageDate = date('Y-m-d');
        }
        $this->_milage= $milage;
    }

    /**
     * Get car milage
     * @return int
     */
    public function getMilage()
    {
        return $this->_milage;
    }

    public function setDailyMilage($dailyMilage)
    {
        $this->_dailyMilage = $dailyMilage;
    }

    public function getDailyMilage()
    {
        return $this->_dailyMilage;
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

    public function getMilageDate()
    {
        return $this->_milageDate;
    }

    public function getWhenUpdated()
    {
        return $this->_whenUpdated;
    }

    /**
     * Return the related "services provided"
     * @param null $parameters
     * @return \Providedservices[]
     */
    public function getProvidedServices($parameters = null)
    {
        //If $params null order by star date
        if (is_null($parameters)) {
            $parameters = array("order" => "_startDate ASC" );
        }
        return $this->getRelated("ProvidedServices", $parameters);
    }

    /**
     * Return the number of days a car was in maintenance
     * @return string
     */
    public function getMaintenanceDays()
    {
        $providedServices = $this->getProvidedServices();
        $daysInMaintenance = 0;
        foreach ($providedServices as $providedService) {
            //Calculate days in maintenance per car
            //TODO exclude services accomplished same day (filter,oil,check all same time period)
            if($providedService->getFinishDate()) {
                //Check if finishdate not same date of startdate
                if(strtotime($providedService->getFinishDate()) - strtotime($providedService->getStartDate()) > 0){
                    $daysInMaintenance += strtotime($providedService->getFinishDate()) - strtotime($providedService->getStartDate());
                }
            }
        }
        //Return number of days not seconds
        return $daysInMaintenance/86400;

    }

    /**
     * Return health according to provided services status
     * @return string
     */
    public function getHealth()
    {
        //TODO refactor health estimation should be done according to pending service types by their weight
        $providedServices = $this->getProvidedServices();
        if ($providedServices->count() == 0) {
            return "Undefined";
        }
        $disabled = 0;
        $dateOk = 0;
        $kmOk = 0;
        foreach ($providedServices as $providedService) {

            if ($providedService->getRemindStatus() == 0) {
                $disabled++;
            } else {
                if ($providedService->getRemindDateStatus() == 'ok') {
                    $dateOk++;
                }
                if ($providedService->getRemindKmStatus() == 'ok') {
                    $kmOk++;
                }
            }
        }
        //Health in %
        $health = 100*($kmOk + $dateOk)/(2*(count($providedServices) - $disabled)).'%';

        return $health;

    }

    /**
     * Return number of issues according to provided status
     * @return string
     */
    public function countIssues()
    {
        $providedServices = $this->getProvidedServices();
        $countIssues = 0;

        foreach ($providedServices as $providedService) {
            if ($providedService->getRemindStatus() != 0) {
                if ($providedService->getRemindDateStatus() == 'alert' || $providedService->getRemindKmStatus() == 'alert') {
                    $countIssues++;
                }
            }
        }

        return $countIssues;
    }
}
