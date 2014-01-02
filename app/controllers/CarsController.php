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
            $this->tag->setDefault("owner", $car->owner);
            $this->tag->setDefault("contactemail", $car->contactemail);
            $this->tag->setDefault("contactphones", $car->contactphones);
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

        $car->id = $this->request->getPost("id");
        $car->regnum = $this->request->getPost("regnum");
        $car->owner = $this->request->getPost("owner");
        $car->contactemail = $this->request->getPost("contactemail");
        $car->contactphones = $this->request->getPost("contactphones");
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
        $car->owner = $this->request->getPost("owner");
        $car->contactemail = $this->request->getPost("contactemail");
        $car->contactphones = $this->request->getPost("contactphones");
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

}
