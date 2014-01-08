<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

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
            $this->tag->setDefault("regnum", $car->regnum);
            $this->tag->setDefault("owner_id", $car->owner_id);
            $this->tag->setDefault("model", $car->model);
            $this->tag->setDefault("bodynumber", $car->bodynumber);
            $this->tag->setDefault("enginenumber", $car->enginenumber);
            $this->tag->setDefault("regdate", $car->regdate);
            $this->tag->setDefault("year", $car->year);
            $this->tag->setDefault("milage", $car->milage);
            $this->tag->setDefault("dailymilage", $car->dailymilage);
            $this->tag->setDefault("moreinfo", $car->moreinfo);
            
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
        $car->regnum = $this->request->getPost("regnum");
        $car->owner_id = $this->request->getPost("owner_id");
        $car->model = $this->request->getPost("model");
        $car->bodynumber = $this->request->getPost("bodynumber");
        $car->enginenumber = $this->request->getPost("enginenumber");
        $car->regdate = $this->request->getPost("regdate");
        $car->year = $this->request->getPost("year");
        $car->milage = $this->request->getPost("milage");
        $car->dailymilage = $this->request->getPost("dailymilage");
        $car->moreinfo = $this->request->getPost("moreinfo");
        

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
        $car->regnum = $this->request->getPost("regnum");
        $car->owner_id = $this->request->getPost("owner_id");
        $car->model = $this->request->getPost("model");
        $car->bodynumber = $this->request->getPost("bodynumber");
        $car->enginenumber = $this->request->getPost("enginenumber");
        $car->regdate = $this->request->getPost("regdate");
        $car->year = $this->request->getPost("year");
        $car->milage = $this->request->getPost("milage");
        $car->dailymilage = $this->request->getPost("dailymilage");
        $car->moreinfo = $this->request->getPost("moreinfo");
        

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

        if (!$this->request->isPost()) {
            $this->flashSession->error("Should be post to update own car data");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Check that user is a client
        if($this->session->get("auth")["role"] == 'Client') {
            $clientId = $this->session->get("auth")["id"];
            $clientUsername = $this->session->get("auth")["username"];
        } else {
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Get car id for update
        $carId = $this->request->getPost("id");

        //Get all client cars ids
        $cars = Cars::find(array(
            'owner_id = :client_id:',
            'bind' => array("client_id" => $clientId),
            'columns' => "id"
        ));
        //Check if client is car owner
        $isOwnCar = false;
        foreach($cars as $id){
            if($id === $carId) {
                $isOwnCar = true;
            }
        }
        if (!$isOwnCar) {
            //Dispatch if not own car
            $this->flashSession->error("Only own car can be edited");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }

        $car = Cars::findFirstByid($carId);
        if (!$car) {
            $this->flash->error("Car does not exist " . $carId);
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        $car->id = $carId;
        $car->milage = $this->request->getPost("milage");
        $car->dailymilage = $this->request->getPost("dailymilage");
        $car->moreinfo = $this->request->getPost("moreinfo");


        if (!$car->save()) {

            foreach ($car->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->response->redirect("/account/".$clientUsername."/view");
        }

        $this->flashSession->success("Car was updated successfully");
        return $this->response->redirect("/account/".$clientUsername."/view");

    }
}
