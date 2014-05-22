<?php

use Phalcon\Mvc\Model\Resultset;
use Phalcon\Db\RawValue;

class ProvidedServices extends \Phalcon\Mvc\Model
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
    protected $_carId;
     
    /**
     *
     * @var integer
     */
    protected $_serviceId;

    /**
     *
     * @var integer
     */
    protected $_inMs;
     
    /**
     *
     * @var integer
     */
    protected $_masterId;

    /**
     *
     * @var string
     */
    protected $_startDate;
     
    /**
     *
     * @var string
     */
    protected $_finishDate;
     
    /**
     *
     * @var integer
     */
    protected $_milage;
     
    /**
     *
     * @var string
     */
    protected $_remindDate;
     
    /**
     *
     * @var integer
     */
    protected $_remindKm;

    /**
     *
     * @var integer
     */
    protected $_remindStatus;

    /**
     *
     * @var string
     */
    protected $_info;

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
            'car_id' => '_carId',
            'service_id' => '_serviceId',
            'in_ms' => '_inMs',
            'master_id' => '_masterId',
            'start_date' => '_startDate',
            'finish_date' => '_finishDate',
            'milage' => '_milage',
            'remind_date' =>  '_remindDate',
            'remind_km'=>'_remindKm' ,
            'remind_status' => '_remindStatus',
            'more_info' => '_info',
            'when_updated'=> '_whenUpdated'
        );
    }

    public function initialize()
    {
        //Get flash session service
        $this->_flashSession = $this->getDI()->getFlashSession();

        //Define relationship with other Models
        $this->belongsTo("_carId", "Cars", "_id");
        $this->belongsTo("_serviceId", "CarServices", "_id");
        $this->belongsTo("_masterId", "Employees", "_id");

        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());
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

    public function setCarByVin($vin)
    {
        $car = Cars::findFirst(array(
            '_vin = ?0',
            'bind' => [$vin]
        ));
        if ($car != false) {
            $this->_carId = $car->getId();
        } else {
            $this->_valid = false;
            $this->_flashSession->error("There is no car with VIN '".$vin."'");
        }
    }

    public function setCarId($id)
    {
        $this->_carId = $id;
    }

    public function getCarId()
    {
        return $this->_carId;
    }

    public function setServiceId($id)
    {
        $this->_serviceId = $id;
    }

    public function getServiceId()
    {
        return $this->_serviceId;
    }

    /**
     * @param int $bool 0 or 1
     */
    public function setInMs($bool)
    {
        if (empty($bool)) {
            $this->_inMs = new RawValue('default');
        } else {
            $this->_inMs = $bool;
        }
    }

    public function getInMs()
    {
        return $this->_inMs;
    }

    public function setMasterId($id)
    {
        $this->_masterId = $id;
    }

    public function getMasterId()
    {
        return $this->_masterId;
    }

    public function setStartDate($date)
    {
        $this->_startDate = $date;
    }

    public function getStartDate()
    {
        return $this->_startDate;
    }

    public function setFinishDate($date)
    {
        if (empty($date)) {
            $this->_finishDate = new RawValue('default');
        } else {
            $this->_finishDate = $date;
        }
    }
    public function getFinishDate()
    {
        return $this->_finishDate;
    }

    public function setMilage($milage)
    {
        //Update milage in related car
        $car = Cars::findFirst(array(
            '_id = ?0',
            'bind' => [$this->getCarId()]
        ));
        $car->setMilage($milage);
        if (!$car->save()) {
            $this->_valid = false;
            foreach ($car->getMessages() as $message) {
                $this->_flashSession->error($message);
            }
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

    public function setRemindDate($date)
    {
        if (empty($date)) {
            $this->_remindDate = new RawValue('default');
        } else {
            $this->_remindDate = $date;
        }
    }
    public function getRemindDate()
    {
        $date = '-';
        if ($this->_remindStatus) {
            $date = $this->_remindDate;
        }
        return $date;
    }

    public function setRemindKm($km)
    {
        if (empty($km)) {
            $this->_remindKm = new RawValue('default');
        } else {
            $this->_remindKm = $km;
        }
    }
    public function getRemindKm()
    {
        return $this->_remindKm;
    }

    /**
     * @param int $bool 0 or 1
     */
    public function setRemindStatus($bool)
    {
        if (empty($bool)) {
            $this->_remindStatus = new RawValue('default');
        } else {
            $this->_remindStatus = $bool;
        }
    }
    public function getRemindStatus()
    {
        return $this->_remindStatus;
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

    /**
     * Return the related "car"
     * @param null $parameters
     * @return \Cars[]
     */
    public function getCar($parameters=null)
    {
        return  $this->getRelated('Cars', $parameters);
    }

    /**
     * Return the related "employee"
     * @param null $parameters
     * @return \Employees[]
     */
    public function getEmployee($parameters=null)
    {
        return  $this->getRelated('Employees', $parameters);
    }

    /**
     * Return the related "car service"
     * @param array $parameters
     * @return \CarServices[]
     */
    public function getService(array $parameters=null)
    {
        return  $this->getRelated('CarServices', $parameters);
    }

    /**
     * Return status for date reminder set in
     * @return string
     */
    public function getRemindDateStatus()
    {
        if($this->_remindStatus > 0) {
            if (time() - strtotime($this->_remindDate) > 0) {
                $status = "alert";
            } else {
                $status = "ok";
            }
        } else {
            $status = 'disabled';
        }

        return $status;
    }

    /**
     * Return status for milage reminder set in service
     * according to related car milage and daily milage properties
     * @param int $milage related car milage
     * @param int $dailyMilage related car daily milage
     * @param string $milageDate related car last milage updated date
     * @return string
     */
    public function getRemindKmStatus($milage=null, $dailyMilage=null, $milageDate=null)
    {
        //Set status as undefined if you don't have enough data
        $status = 'undefined';
        //If remind status false then status disabled
        if ($this->_remindStatus > 0) {
            //If null get from related model
            if (is_null($milage) || is_null($dailyMilage) || is_null($milageDate)) {
                $car = $this->getCar();
                $milage = $car->getMilage();
                $dailyMilage = $car->getDailyMilage();
                $milageDate = $car->getMilageDate();
            }
             //Get number of days between now and last milage updated
            $days = round((time() - strtotime($milageDate))/86400);
            //Get estimated km after last milage data update
            $kmSince = $days*$dailyMilage;

            if ($this->_remindKm > 0 && ($this->getMilageRemind()  - ($milage + $kmSince)) < 0) {
                $status = "alert";
            } else {
                $status = "ok";
            }

        } else {
            $status = 'disabled';
        }

        return $status;
    }

    /**
     * Return milage reminder according to odometer
     * @return int
     */
    public function getMilageRemind()
    {
        $milage = 0;
        //Show total milage as reminder if remind status true
        if ($this->_remindStatus) {
            $milage = $this->_remindKm + $this->_milage;
        }
        return $milage;
    }
     
}
