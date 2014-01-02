<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class CarservicesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for carservices
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Carservices", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $carservices = Carservices::find($parameters);
        if (count($carservices) == 0) {
            $this->flash->notice("The search did not find any carservices");
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $carservices,
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
     * Edits a carservice
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $carservice = Carservices::findFirstByid($id);
            if (!$carservice) {
                $this->flash->error("carservice was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "carservices",
                    "action" => "index"
                ));
            }

            $this->view->id = $carservice->id;

            $this->tag->setDefault("id", $carservice->id);
            $this->tag->setDefault("carservice", $carservice->carservice);
            $this->tag->setDefault("moreinfo", $carservice->moreinfo);
            
        }
    }

    /**
     * Creates a new carservice
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $carservice = new Carservices();

        $carservice->id = $this->request->getPost("id");
        $carservice->carservice = $this->request->getPost("carservice");
        $carservice->moreinfo = $this->request->getPost("moreinfo");
        

        if (!$carservice->save()) {
            foreach ($carservice->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "new"
            ));
        }

        $this->flash->success("carservice was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "carservices",
            "action" => "index"
        ));

    }

    /**
     * Saves a carservice edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $carservice = Carservices::findFirstByid($id);
        if (!$carservice) {
            $this->flash->error("carservice does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $carservice->id = $this->request->getPost("id");
        $carservice->carservice = $this->request->getPost("carservice");
        $carservice->moreinfo = $this->request->getPost("moreinfo");
        

        if (!$carservice->save()) {

            foreach ($carservice->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "edit",
                "params" => array($carservice->id)
            ));
        }

        $this->flash->success("carservice was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "carservices",
            "action" => "index"
        ));

    }

    /**
     * Deletes a carservice
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $carservice = Carservices::findFirstByid($id);
        if (!$carservice) {
            $this->flash->error("carservice was not found");
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        if (!$carservice->delete()) {

            foreach ($carservice->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "search"
            ));
        }

        $this->flash->success("carservice was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "carservices",
            "action" => "index"
        ));
    }

}
