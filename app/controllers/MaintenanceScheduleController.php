<?php
use Phalcon\Mvc\Model\Resultset;

class MaintenanceScheduleController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        //Get all models
        $carModels = CarModels::find();
        //Get all services
        $carServices = CarServices::find()->setHydrateMode(Resultset::HYDRATE_OBJECTS);
        //Send it via json serialized
        $data = array();
        foreach ($carServices as $carService) {
            $data[] = array(
                'id' => $carService->id,
                'name' =>$carService->service,
            );
        }
        $services = json_encode($data,JSON_UNESCAPED_UNICODE);

        $this->view->carModels = $carModels;
        $this->view->carServices = $services;
    }

    /**
     * Creates a new maintenance schedule
     */
    public function createAction()
    {

    }
}

