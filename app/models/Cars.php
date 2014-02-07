<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;

class Cars extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     * Vehicle identification number
     * @var string
     */
    public $vin;

    /**
     *
     * @var string
     */
    public $regNumber;
     
    /**
     *
     * @var integer
     */
    public $ownerId;
     
    /**
     *
     * @var integer
     */
    public $modelId;

    /**
     *
     * @var string
     */
    public $regDate;
     
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
    public $dailyMilage;
     
    /**
     *
     * @var string
     */
    public $moreInfo;

    /**
     * When last milage updated
     * @var date
     */
    public $milageDate;

    /**
     * current timestamp on each update
     * @var timestamp
     */
    public $whenUpdated;

    public function columnMap()
    {
        //Keys are the real names in the table and
        //the values their names in the application
         return array(
            'id' => 'id',
            'vin' => 'vin',
            'registration_number' => 'regNumber',
            'owner_id' => 'ownerId',
            'model_id' => 'modelId',
            'registered_date' => 'regDate',
            'year' => 'year',
            'milage' => 'milage',
            'daily_milage' =>  'dailyMilage',
            'more_info'=>'moreInfo' ,
            'milage_date' => 'milageDate',
            'when_updated'=> 'whenUpdated'
        );
    }


    public function initialize()
    {
        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(array('when_updated'));

        //Set has-many cars relationship
        $this->hasMany("id", "ProvidedServices", "carId");

        //Set belongs to model relationship
        $this->belongsTo("modelId", "CarModels", "_id");

        //Insert date on creation for milage date
        //TODO test Behavior
        $this->addBehavior(new Timestampable(array(
            'beforeCreate' => array('field' => 'milageDate','format' => 'Y-m-d H:i:s')
        )));

        //Use dynamic update to improve performance
        $this->useDynamicUpdate(true);

        //Log model events
        $this->addBehavior(new Blamable());

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
            $parameters = array("order" => "startDate ASC" );
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
            if(isset($providedService->finishDate)) {
                //Check if finishdate not same date of startdate
                if(strtotime($providedService->finishDate) - strtotime($providedService->startDate) > 0){
                    $daysInMaintenance += strtotime($providedService->finishDate) - strtotime($providedService->startDate);
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

            if ($providedService->remindStatus == 0) {
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
            if ($providedService->remindStatus != 0) {
                if ($providedService->getRemindDateStatus() == 'alert' || $providedService->getRemindKmStatus() == 'alert') {
                    $countIssues++;
                }
            }
        }

        return $countIssues;
    }
}
