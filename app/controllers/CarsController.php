<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CarsController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $this->view->clients = Clients::find();
    }

    /**
     * Searches for cars
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Cars", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $cars = Cars::find($parameters);
        if (count($cars) == 0) {
            $this->flash->notice("The search did not find any cars");
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $cars,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a car
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $car = Cars::findFirstByid($id);
            if (!$car) {
                $this->flash->error("car was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "cars",
                    "action" => "index"
                ));
            }

            $this->view->id = $car->id;

            $this->tag->setDefault("id", $car->id);
            $this->tag->setDefault("vin", $car->vin);
            $this->tag->setDefault("registration_number", $car->regNumber);
            $this->tag->setDefault("owner_id", $car->ownerId);
            $this->tag->setDefault("model_id", $car->modelId);
            $this->tag->setDefault("registered_date", $car->regDate);
            $this->tag->setDefault("year", $car->year);
            $this->tag->setDefault("milage", $car->milage);
            $this->tag->setDefault("daily_milage", $car->dailyMilage);
            $this->tag->setDefault("more_info", $car->moreInfo);
            $this->tag->setDefault("when_updated", $car->whenUpdated);
            
        }
    }

    /**
     * Creates a new car
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "index"
            ));
        }

        $car = new Cars();
        $this->view->clients = Clients::find();

        $car->id = $this->request->getPost("id");
        $car->vin = $this->request->getPost("vin");
        $car->regNumber = $this->request->getPost("registration_number");
        $car->ownerId = $this->request->getPost("owner_id");
        $car->modelId = $this->request->getPost("model_id");
        //Set registration date as creation date
        $car->regDate = date('Y-m-d');
        $car->year = $this->request->getPost("year");
        $car->milage = $this->request->getPost("milage");
        $car->dailyMilage = $this->request->getPost("daily_milage");
        $car->moreInfo = $this->request->getPost("more_info");
        //Set milage date if milage isset
        if(isset($car->milage)) {
            $car->milageDate = date('Y-m-d');
        }
        

        if (!$car->save()) {
            foreach ($car->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "new"
            ));
        }

        $this->flash->success("car was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "cars",
            "action" => "index"
        ));

    }

    /**
     * Saves a car edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $car = Cars::findFirstByid($id);
        if (!$car) {
            $this->flash->error("car does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "index"
            ));
        }

        $car->id = $this->request->getPost("id");
        $car->vin = $this->request->getPost("vin");
        $car->regNumber = $this->request->getPost("registration_number");
        $car->ownerId = $this->request->getPost("owner_id");
        $car->modelId = $this->request->getPost("model_id");
        $car->year = $this->request->getPost("year");
        $car->milage = $this->request->getPost("milage");
        $car->dailyMilage = $this->request->getPost("daily_milage");
        $car->moreInfo = $this->request->getPost("more_info");
        //Set new milage date if changed
        if($car->milage != $this->request->getPost("milage") ) {
            $car->milageDate = date('Y-m-d');
        }


        if (!$car->save()) {

            foreach ($car->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "edit",
                "params" => array($car->id)
            ));
        }

        $this->flash->success("car was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "cars",
            "action" => "index"
        ));

    }

    /**
     * Deletes a car
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $car = Cars::findFirstByid($id);
        if (!$car) {
            $this->flash->error("car was not found");
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "index"
            ));
        }

        if (!$car->delete()) {

            foreach ($car->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "search"
            ));
        }

        $this->flash->success("car was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "cars",
            "action" => "index"
        ));
    }

    /**
     * Saves a client car edited by client
     * TODO refactor function to be DRY
     */
    public function updateOwnAction()
    {
        $clientUsername = $this->session->get("auth")["username"];
        if (!$this->request->isPost()) {
            $this->flashSession->error("Should be post to update own car data");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Check that user is a client
        if($this->session->get("auth")["role"] == 'Client') {
            $clientId = $this->session->get("auth")["id"];
            $clientUsername = $this->session->get("auth")["username"];
        } else {
            $this->flashSession->error("You should be a Client to edit that data");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Get car id for update
        $carId = $this->request->getPost("id");

        //Get all client cars ids
        $cars = Cars::find(array(
            'ownerId = :client_id:',
            'bind' => array("client_id" => $clientId),
            'columns' => "id"
        ));
        //Check if client is car owner
        $isOwnCar = false;
        foreach($cars as $car){
            if($car->id == $carId) {
                $isOwnCar = true;
            }
        }
        if (!$isOwnCar) {
            //Redirect if not own car
            $this->flashSession->error("Only own car can be edited");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }

        $car = Cars::findFirstByid($carId);

        if($this->request->getPost("milage")) {
            $car->milage = $this->request->getPost("milage");
            //Update milage date
            $car->milageDate = date('Y-m-d');
        }
        if($this->request->getPost("daily_milage")) {
            $car->dailyMilage = $this->request->getPost("daily_milage");
        }
        if($this->request->getPost("more_info")) {
            $car->moreInfo = $this->request->getPost("more_info");
        }


        if (!$car->save()) {

            foreach ($car->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->response->redirect("/account/".$clientUsername."/view");
        }


        echo json_encode($car);
        $this->view->disable();

    }

    /**
     * Find Car by VIN
     */
    //Set default to null if user try to access url without params
    //TODO refactor
    public function findByVinAction($vin = null)
    {
        //Check if $vin isset
        if (!isset($vin)) {
            $this->flashSession->error("The VIN should be not empty");
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "findByVin",
                "params" => array("0")
            ));
        }
        //TODO check correctness of VIN number by regex
        if($vin == null || $vin == "0") {
            $this->flashSession->error("Wrong VIN number");
            //TODO render to some extent
            $this->view->disable();
            //$this->view->disableLevel('View::LEVEL_ACTION_VIEW');
        } else {
            //Prepare to sanitize
            $vin = urldecode($vin);
            //Get VIN
            $vin = explode('-',$vin)[1];
            //Sanitize VIN
            $vin = $this->filter->sanitize($vin,"trim");
            $vin = $this->filter->sanitize($vin,"striptags");
            $vin = $this->filter->sanitize($vin,"alphanum");

            //Get car and related services by vin
            $car = Cars::findFirst("vin ='".$vin."'");

            if ($car != '') {

                $providedServices = $car->getProvidedServices(array(
                    "cache" => array("key" => "providedServices-list-".$car->id, "lifetime" => 300)
                ))->setHydrateMode(Resultset::HYDRATE_OBJECTS);

                //Make resultset available in view
                $this->view->car = $car;
                $this->view->providedServices = $providedServices;

                //Get all employees and cache it
                $this->view->employees = Employees::find(array(
                    "columns" => "id, fullname, job, contacts",
                    "cache" => array("key" => "employees-list", "lifetime" => 300)
                ));

                //Get all services and cache it
                $this->view->carServices = CarServices::find( array(
                    "cache" => array("key" => "car-services-list", "lifetime" => 300)
                ));
            }  else {
                $this->flash->error("The search by Vin did not find any cars");
                return $this->dispatcher->forward(array(
                    "controller" => "cars",
                    "action" => "findByVin",
                    "params" => array("0")
                ));
                //TODO render to some extent
                $this->view->disable();
                //$this->view->disableLevel('View::LEVEL_ACTION_VIEW');
            }
        }

    }
}
