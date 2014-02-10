<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class CarServicesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");
        $this->persistent->parameters = null;
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "carservice";

        $carServices = Carservices::find($parameters);
        if (count($carServices) == 0) {
            $this->flash->notice("<h1>There is no carservices</h1>");
        }

        $paginator = new Paginator(array(
            "data" => $carServices,
            "limit"=> 100,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    /**
     * List all carServices
     */
    public function listAction()
    {
        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");
        $this->persistent->parameters = null;
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "carservice";

        $carServices = Carservices::find($parameters);
        if (count($carServices) == 0) {
            $this->flash->notice("There is no car services");
        }

        $paginator = new Paginator(array(
            "data" => $carServices,
            "limit"=> 100,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    /**
     * Searches for carServices
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "CarServices", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $carServices = CarServices::find($parameters);
        if (count($carServices) == 0) {
            $this->flash->notice("The search did not find any car services");
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $carServices,
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
        $this->view->carServices = CarServices::find();
    }

    /**
     * Edits a carService
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $carService = Carservices::findFirstByid($id);
            if (!$carService) {
                $this->flash->error("carservice was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "carservices",
                    "action" => "index"
                ));
            }

            $this->view->id = $carService->id;

            $this->tag->setDefault("id", $carService->id);
            $this->tag->setDefault("service", $carService->service);
            $this->tag->setDefault("more_info", $carService->moreInfo);
            
        }
    }

    /**
     * Creates a new carService
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $carService = new CarServices();

        $carService->setService($this->request->getPost("service"));
        $carService->setInfo($this->request->getPost("more_info"));
        

        if (!$carService->save()) {
            foreach ($carService->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "new"
            ));
        }

        $this->flashSession->success("Car service '".$carService->getService()."' was created successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

    }

    /**
     * Saves a carService edited
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

        $carService = CarServices::findFirstByid($id);
        if (!$carService) {
            $this->flash->error("Car service does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        $carService->id = $this->request->getPost("id");
        $carService->service = $this->request->getPost("service");
        $carService->moreInfo = $this->request->getPost("more_info");
        

        if (!$carService->save()) {

            foreach ($carService->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "edit",
                "params" => array($carService->id)
            ));
        }

        $this->flash->success("Car service was updated successfully");
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

        $carService = CarServices::findFirstByid($id);
        if (!$carService) {
            $this->flash->error("Car service was not found");
            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "index"
            ));
        }

        if (!$carService->delete()) {

            foreach ($carService->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "carservices",
                "action" => "search"
            ));
        }

        $this->flash->success("Car service was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "carservices",
            "action" => "index"
        ));
    }

}
