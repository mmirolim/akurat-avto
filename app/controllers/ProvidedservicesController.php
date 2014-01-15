<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

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
     * Searches for ProvidedServices
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "ProvidedServices", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $providedServices = ProvidedServices::find($parameters);
        if (count($providedServices) == 0) {
            $this->flash->notice("The search did not find any provided services");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $providedServices,
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
        $this->view->services = CarServices::find();
        $this->view->employees = Employees::find();
    }

    /**
     * Edits a ProvidedService
     *
     * @param string $id
     */
    public function editAction($id = null)
    {

        if (!$this->request->isPost() && $this->request->getPost("id") > 0) {

            $providedService = ProvidedServices::findFirstByid($id);
            if (!$providedService) {
                $this->flash->error("A provided service was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "providedservices",
                    "action" => "index"
                ));
            }

            $this->view->id = $providedService->id;

            $this->tag->setDefault("id", $providedService->id);
            $this->tag->setDefault("car_id", $providedService->carId);
            $this->tag->setDefault("service_id", $providedService->serviceId);
            $this->tag->setDefault("master_id", $providedService->masterId);
            $this->tag->setDefault("start_date", $providedService->startDate);
            $this->tag->setDefault("finish_date", $providedService->finishDate);
            $this->tag->setDefault("milage", $providedService->milage);
            $this->tag->setDefault("remind_date", $providedService->remindDate);
            $this->tag->setDefault("remind_km", $providedService->remindKm);
            $this->tag->setDefault("remind_status", $providedService->remindStatus);
            $this->tag->setDefault("more_info", $providedService->moreInfo);

        }
    }

    /**
     * Creates a new ProvidedService
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $providedService = new Providedservices();

        $providedService->id = $this->request->getPost("id");
        $providedService->carId = $this->request->getPost("car_id");
        $providedService->serviceId = $this->request->getPost("service_id");
        $providedService->masterId = $this->request->getPost("master_id");
        $providedService->startDate = $this->request->getPost("start_date");
        $providedService->finishDate = $this->request->getPost("finish_date");
        $providedService->milage = $this->request->getPost("milage");
        $providedService->remindDate = $this->request->getPost("remind_date");
        $providedService->remindKm = $this->request->getPost("remind_km");
        $providedService->moreInfo = $this->request->getPost("more_info");
        //TODO make it recieve checkbox value
        $providedService->remindStatus = $this->request->getPost("remind_status");
        

        if (!$providedService->save()) {
            foreach ($providedService->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "new"
            ));
        }

        $this->flash->success("The provided service was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));

    }

    /**
     * Saves a ProvidedService edited
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

        $providedService = ProvidedServices::findFirstByid($id);
        if (!$providedService) {
            $this->flash->error("A provided service does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $providedService->id = $this->request->getPost("id");
        $providedService->carId = $this->request->getPost("car_id");
        $providedService->serviceId = $this->request->getPost("service_id");
        $providedService->masterId = $this->request->getPost("master_id");
        $providedService->startDate = $this->request->getPost("start_date");
        $providedService->finishDate = $this->request->getPost("finish_date");
        $providedService->milage = $this->request->getPost("milage");
        $providedService->remindDate = $this->request->getPost("remind_date");
        $providedService->remindKm = $this->request->getPost("remind_km");
        $providedService->more_info = $this->request->getPost("more_info");
        $providedService->remindStatus = $this->request->getPost("remind_status");
        

        if (!$providedService->save()) {

            foreach ($providedService->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "edit",
                "params" => array($providedService->id)
            ));
        }

        $this->flash->success("The provided service was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));

    }

    /**
     * Deletes a ProvidedService
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $providedService = ProvidedServices::findFirstByid($id);
        if (!$providedService) {
            $this->flash->error("A provided service was not found");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        if (!$providedService->delete()) {

            foreach ($providedService->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "search"
            ));
        }

        $this->flash->success("The provided service was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));
    }

}
