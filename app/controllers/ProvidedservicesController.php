<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Db\RawValue as RawValue;

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
        $this->view->carServices = CarServices::find();
        $this->view->employees = Employees::find();
    }

    /**
     * Edits a ProvidedService
     *
     * @param string $id
     */
    public function editAction($id = null)
    {

        if (!is_null($id)) {

            $providedService = ProvidedServices::findFirst(array(
                'id = ?0',
                'bind' => [$id]
            ));
            if (!$providedService) {
                $this->flash->error("A provided service was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "providedservices",
                    "action" => "index"
                ));
            }
            $this->view->carServices = CarServices::find();
            $this->view->employees = Employees::find();
            $car = Cars::findFirst(array(
                '_id = ?0',
                'bind' => [$providedService->carId]
            ));

            //Set default values to form elements
            $this->tag->setDefault("vin",$car->getVin());
            $this->tag->setDefault("id",$providedService->id);
            $this->tag->setDefault("service_id",$providedService->serviceId);
            $this->tag->setDefault("milage",$providedService->milage);
            $this->tag->setDefault("in_ms",$providedService->inMs);
            $this->tag->setDefault("remind",$providedService->remindStatus);
            $this->tag->setDefault("master_id",$providedService->masterId);
            $this->tag->setDefault("start_date",$providedService->startDate);
            $this->tag->setDefault("finish_date",$providedService->finishDate);
            $this->tag->setDefault("remind_date",$providedService->remindDate);
            $this->tag->setDefault("remind_km",$providedService->remindKm);
            $this->tag->setDefault("more_info",$providedService->moreInfo);

            $this->view->car = $car;
            $this->view->providedService = $providedService;

        } else {
            //Show empty page
            $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }

    }

    /**
     * Creates a new ProvidedService
     */
    public function createAction()
    {
        //TODO move integrity and validation logic to model
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        $providedService = new Providedservices();

        if ($this->request->getPost("vin")) {
            $vin = $this->request->getPost("vin");
            $car = Cars::findFirst(array(
                '_vin = ?0',
                'bind' => [$vin]
            ));
            if ($car != false) {
                $providedService->carId = $car->getId();
            } else {
                $this->flashSession->error("There is no car with vin equal to '$vin'");
                return $this->dispatcher->forward(array(
                    "controller" => "providedservices",
                    "action" => "new"
                ));
            }
        }
        $providedService->milage = $this->request->getPost("milage");
        $providedService->serviceId = $this->request->getPost("service_id");
        //TODO make it recieve checkbox value
        if ($this->request->getPost("in_ms")) {
            $providedService->inMs = $this->request->getPost("in_ms");
        } else {
            $providedService->inMs = new RawValue('default');
        }
        //TODO make it recieve checkbox value
        if ($this->request->getPost("remind")) {
            $providedService->remindStatus = $this->request->getPost("remind");
        } else {
            $providedService->remindStatus = new RawValue('default');
        }
        $providedService->masterId = $this->request->getPost("master_id");
        $providedService->startDate = $this->request->getPost("start_date");

        if ($this->request->getPost("finish_date")) {
            $providedService->finishDate = $this->request->getPost("finish_date");
        } else {
            $providedService->finishDate = new RawValue('default');
        }

        if ($this->request->getPost("remind_date")) {
            $providedService->remindDate = $this->request->getPost("remind_date");
        } else {
            $providedService->remindDate = new RawValue('default');
        }
        if ($this->request->getPost("remind_km")) {
            $providedService->remindKm = $this->request->getPost("remind_km");
        } else {
            $providedService->remindKm = new RawValue('default');
        }
        if ($this->request->getPost("more_info")) {
            $providedService->moreInfo = $this->request->getPost("more_info");
        } else {
            $providedService->moreInfo = new RawValue('default');
        }


        if (!$providedService->save()) {
            foreach ($providedService->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "new"
            ));
        }

        $this->flashSession->success("The provided service for car '$vin' was created successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

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

        $providedService = ProvidedServices::findFirstById($id);
        if (!$providedService) {
            $this->flashSession->error("A provided service does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }
        $vin = $providedService->carId = $this->request->getPost("vin");
        $car = Cars::findFirst(array(
            '_vin = ?0',
            'bind' => [$vin]
        ));
        if ($car == false) {
            $this->flashSession->error("There is no car with VIN '$vin'");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "edit",
                "params" => array($providedService->id)
            ));
        }
        $providedService->carId = $car->getId();
        $providedService->id = $this->request->getPost("id");
        $providedService->serviceId = $this->request->getPost("service_id");
        $providedService->masterId = $this->request->getPost("master_id");
        $providedService->startDate = $this->request->getPost("start_date");
        $providedService->finishDate = $this->request->getPost("finish_date");
        $providedService->milage = $this->request->getPost("milage");
        $providedService->remindDate = $this->request->getPost("remind_date");
        $providedService->remindKm = $this->request->getPost("remind_km");
        $providedService->more_info = $this->request->getPost("more_info");
        $providedService->remindStatus = $this->request->getPost("remind");
        

        if (!$providedService->save()) {

            foreach ($providedService->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "edit",
                "params" => array($providedService->id)
            ));
        }

        $this->flashSession->success("The provided service with id '$providedService->id' was updated successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

    }

    /**
     * Confirm delete action
     */
    public function confirmAction($id=null)
    {
        $this->view->id = $id;
    }

    /**
     * Deletes a ProvidedService
     *
     * @param string $id
     */
    public function deleteAction($id = null)
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
