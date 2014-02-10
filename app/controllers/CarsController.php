<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Db\RawValue as RawValue;
use Phalcon\Mvc\View;

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
        $this->view->carModels = CarModels::find(array('hydration' => Resultset::HYDRATE_ARRAYS));
    }

    /**
     * Edits a car
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $car = Cars::findFirst(array(
                '_id = ?0',
                'bind' => [$id]
            ));
            if (!$car) {
                $this->flash->error("car was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "cars",
                    "action" => "index"
                ));
            }
            $this->view->carModels = CarModels::find(array('hydration' => Resultset::HYDRATE_ARRAYS));
            $this->view->id = $car->getId();

            $this->tag->setDefault("id", $car->getId());
            $this->tag->setDefault("vin", $car->getVin());
            $this->tag->setDefault("registration_number", $car->getRegNumber());
            $this->tag->setDefault("username", $car->clients->getUsername());
            $this->tag->setDefault("model_id", $car->getModelId());
            $this->tag->setDefault("registered_date", $car->getRegDate());
            $this->tag->setDefault("year", $car->getYear());
            $this->tag->setDefault("milage", $car->getMilage());
            $this->tag->setDefault("daily_milage", $car->getDailyMilage());
            $this->tag->setDefault("more_info", $car->getInfo());
            $this->tag->setDefault("when_updated", $car->getWhenUpdated());
            $this->tag->setDefault("milage_date", $car->getMilageDate());
            
        }
    }

    /**
     * Creates a new car
     */
    public function createAction()
    {
        //TODO move integrity logic to Model
        if (!$this->request->isPost()) {
            return $this->view->disableLevel(View::LEVEL_ACTION_VIEW);
        }

        $car = new Cars();
        $car->setVin(strtoupper($this->request->getPost("vin")));
        $car->setRegNumber(strtoupper($this->request->getPost("registration_number")));
        $car->setOwner($this->request->getPost("username"));
        $car->setModelId($this->request->getPost("model_id"));
        $car->setYear($this->request->getPost("year"));
        $car->setMilage($this->request->getPost("milage"));
        $car->setDailyMilage($this->request->getPost("daily_milage"));
        $car->setInfo($this->request->getPost("more_info"));
        $car->setRegDate();

        if (!$car->save()) {
            foreach ($car->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "new"
            ));
        }

        $this->flashSession->success("Car '".$car->getVin()."' was created successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

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

        $car = Cars::findFirst(array(
            '_id = ?0',
            'bind' => [$id]
        ));

        if (!$car) {
            $this->flashSession->error("car does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "index"
            ));
        }

        $car->setVin($this->request->getPost("vin"));
        $car->setRegNumber($this->request->getPost("registration_number"));
        $car->setOwner($this->request->getPost("username"));
        $car->setModelId($this->request->getPost("model_id"));
        $car->setYear($this->request->getPost("year"));
        $car->setMilage($this->request->getPost("milage"));
        $car->setDailyMilage($this->request->getPost("daily_milage"));
        $car->setInfo($this->request->getPost("more_info"));

        if (!$car->save()) {

            foreach ($car->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cars",
                "action" => "edit",
                "params" => array($car->id)
            ));
        }

        $this->flashSession->success("The car with id '".$car->getId()."' was updated successfully");
        //TODO use dispatch instead of redirect
        return $this->response->redirect($this->elements->getAccountRoute());

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
            //TODO fix flash messages not shown
            return $this->response->redirect("/client/".$clientUsername);
        }
        //Check that user is a client
        if($this->session->get("auth")["role"] == 'Client') {
            $clientId = $this->session->get("auth")["id"];
            $clientUsername = $this->session->get("auth")["username"];
        } else {
            $this->flashSession->error("You should be a Client to edit that data");
            return $this->response->redirect("/client/".$clientUsername);
        }
        //Get car id for update
        $carId = $this->request->getPost("id");

        //Get all client cars ids
        $cars = Cars::find(array(
            '_ownerId = ?0',
            'bind' => [$clientId],
            'columns' => "_id"
        ));
        //Check if client is car owner
        $isOwnCar = false;
        foreach($cars as $car){
            if($car->_id == $carId) {
                $isOwnCar = true;
            }
        }
        if (!$isOwnCar) {
            //Redirect if not own car
            $this->flashSession->error("Only own car can be edited");
            return var_dump($cars);
            $this->view->disable();
            //return $this->response->redirect("/client/".$clientUsername);
        }

        $car = Cars::findFirst(array(
            '_id = ?0',
            'bind' => [$carId]
        ));
        if($this->request->getPost("milage")) {
            $car->setMilage($this->request->getPost("milage"));
        }
        if($this->request->getPost("daily_milage")) {
            $car->setDailyMilage($this->request->getPost("daily_milage"));
        }
        if($this->request->getPost("more_info")) {
            $car->setInfo($this->request->getPost("more_info"));
        }


        if (!$car->save()) {

            foreach ($car->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->response->redirect("/client/".$clientUsername);
        }

        $obj = new stdClass();
        $obj->id = $car->getId();
        $obj->vin = $car->getVin();
        $obj->milage = $car->getMilage();
        $obj->dailyMilage = $car->getDailyMilage();
        $obj->more_info = $car->getInfo();

        echo json_encode($obj);
        $this->view->disable();

    }

    /**
     * Find Car by VIN or registration number
     * @param null $identity
     */

    public function vinAction($identity = null)
    {
        //Check if $identity is null
        if(is_null($identity)) {
            $identity = $this->request->getPost("car-identity");
        }
        //Get car and related services by vin or registration number
        $car = Cars::findFirst(array(
            '_vin = :identity: OR _regNumber = :identity:',
            'bind' => array('identity' => $identity)
        ));

        if ($car != '') {
            //Make resultset available in view
            //Get all employees and cache it
            $this->view->employees = Employees::inArrayById(array(
                "columns" => "_id, _fullname, _job, _contacts",
            ));

            //Get all services and cache it
            $this->view->carServices = CarServices::inArrayById( array(
            ));

            $this->view->client = Clients::findFirst($car->getOwnerId());

            $this->view->car = $car;
            $this->view->providedServices = $car->getProvidedServices();

        }  else {
            $this->flashSession->error("The search by Vin did not find any cars");
        }

    }

}
