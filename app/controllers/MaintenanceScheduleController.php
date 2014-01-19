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
        $clientUsername = $this->session->get("auth")["username"];
        if (!$this->request->isPost()) {
            $this->flashSession->error("Should be post to save configuration");
        }
        //Check that user is a client
        if($this->session->get("auth")["role"] == 'Admin') {
            $clientId = $this->session->get("auth")["id"];
            $clientUsername = $this->session->get("auth")["username"];
        } else {
            $this->flashSession->error("You should be an Admin");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Get model id
        $modelId = $this->request->getPost("model_id");
        $conf = $this->request->getPost("conf");

        $schedule = new MaintenanceSchedule();
        $schedule->modelId = $modelId;
        $schedule->conf = $conf;
        $status = '';
        if (!$schedule->save()) {

            foreach ($schedule->getMessages() as $message) {
                $status .= $message;
            }
        } else {
            $status = "Car was created successfully";
        }

        echo $status;

        $this->view->disable();
    }

    public function saveAction()
    {

    }

    public function editAction()
    {

    }
}

