<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class ProvidedservicesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for providedservices
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Providedservices", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $providedservices = Providedservices::find($parameters);
        if (count($providedservices) == 0) {
            $this->flash->notice("The search did not find any providedservices");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $providedservices,
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
     * Edits a providedservice
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $providedservice = Providedservices::findFirstByid($id);
            if (!$providedservice) {
                $this->flash->error("providedservice was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "providedservices",
                    "action" => "index"
                ));
            }

            $this->view->id = $providedservice->id;

            $this->tag->setDefault("id", $providedservice->id);
            $this->tag->setDefault("car_id", $providedservice->car_id);
            $this->tag->setDefault("work_id", $providedservice->work_id);
            $this->tag->setDefault("master_id", $providedservice->master_id);
            $this->tag->setDefault("cost", $providedservice->cost);
            $this->tag->setDefault("startdate", $providedservice->startdate);
            $this->tag->setDefault("finishdate", $providedservice->finishdate);
            $this->tag->setDefault("milage", $providedservice->milage);
            $this->tag->setDefault("reminddate", $providedservice->reminddate);
            $this->tag->setDefault("remindkm", $providedservice->remindkm);
            $this->tag->setDefault("moreinfo", $providedservice->moreinfo);
            
        }
    }

    /**
     * Creates a new providedservice
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $providedservice = new Providedservices();

        $providedservice->id = $this->request->getPost("id");
        $providedservice->car_id = $this->request->getPost("car_id");
        $providedservice->work_id = $this->request->getPost("work_id");
        $providedservice->master_id = $this->request->getPost("master_id");
        $providedservice->cost = $this->request->getPost("cost");
        $providedservice->startdate = $this->request->getPost("startdate");
        $providedservice->finishdate = $this->request->getPost("finishdate");
        $providedservice->milage = $this->request->getPost("milage");
        $providedservice->reminddate = $this->request->getPost("reminddate");
        $providedservice->remindkm = $this->request->getPost("remindkm");
        $providedservice->moreinfo = $this->request->getPost("moreinfo");
        

        if (!$providedservice->save()) {
            foreach ($providedservice->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "new"
            ));
        }

        $this->flash->success("providedservice was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));

    }

    /**
     * Saves a providedservice edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $providedservice = Providedservices::findFirstByid($id);
        if (!$providedservice) {
            $this->flash->error("providedservice does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $providedservice->id = $this->request->getPost("id");
        $providedservice->car_id = $this->request->getPost("car_id");
        $providedservice->work_id = $this->request->getPost("work_id");
        $providedservice->master_id = $this->request->getPost("master_id");
        $providedservice->cost = $this->request->getPost("cost");
        $providedservice->startdate = $this->request->getPost("startdate");
        $providedservice->finishdate = $this->request->getPost("finishdate");
        $providedservice->milage = $this->request->getPost("milage");
        $providedservice->reminddate = $this->request->getPost("reminddate");
        $providedservice->remindkm = $this->request->getPost("remindkm");
        $providedservice->moreinfo = $this->request->getPost("moreinfo");
        

        if (!$providedservice->save()) {

            foreach ($providedservice->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "edit",
                "params" => array($providedservice->id)
            ));
        }

        $this->flash->success("providedservice was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));

    }

    /**
     * Deletes a providedservice
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $providedservice = Providedservices::findFirstByid($id);
        if (!$providedservice) {
            $this->flash->error("providedservice was not found");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        if (!$providedservice->delete()) {

            foreach ($providedservice->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "search"
            ));
        }

        $this->flash->success("providedservice was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));
    }

}
