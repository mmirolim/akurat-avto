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

        //TODO refactor flow
        if (!is_null($id)) {
            $providedService = ProvidedServices::findFirst(array(
                '_id = ?0',
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
                'bind' => [$providedService->getCarId()]
            ));

            //Set default values to form elements
            $this->tag->setDefault("vin",$car->getVin());
            $this->tag->setDefault("id",$providedService->getId());
            $this->tag->setDefault("service_id",$providedService->getServiceId());
            $this->tag->setDefault("milage",$providedService->getMilage());
            $this->tag->setDefault("in_ms",$providedService->getInMs());
            $this->tag->setDefault("remind",$providedService->getRemindStatus());
            $this->tag->setDefault("master_id",$providedService->getMasterId());
            $this->tag->setDefault("start_date",$providedService->getStartDate());
            $this->tag->setDefault("finish_date",$providedService->getFinishDate());
            $this->tag->setDefault("remind_date",$providedService->getRemindDate());
            $this->tag->setDefault("remind_km",$providedService->getRemindKm());
            $this->tag->setDefault("more_info",$providedService->getInfo());

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
        $vin = $this->request->getPost("vin");
        if ($vin) {
            $providedService->setCarByVin($vin);
        }
        $providedService->setMilage($this->request->getPost("milage"));
        $providedService->setServiceId($this->request->getPost("service_id"));
        $providedService->setInMs($this->request->getPost("in_ms"));
        $providedService->setRemindStatus($this->request->getPost("remind"));
        $providedService->setMasterId($this->request->getPost("master_id"));
        $providedService->setStartDate($this->request->getPost("start_date"));
        $providedService->setFinishDate($this->request->getPost("finish_date"));
        $providedService->setRemindDate($this->request->getPost("remind_date"));
        $providedService->setRemindKm($this->request->getPost("remind_km"));
        $providedService->setInfo($this->request->getPost("more_info"));


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
        $providedService = ProvidedServices::findFirst(array(
            '_id = ?0',
            'bind' => [$id]
        ));
        if (!$providedService) {
            $this->flashSession->error("A provided service does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }
        $vin = $this->request->getPost("vin");
        $car = Cars::findFirst(array(
            '_vin = ?0',
            'bind' => [$vin]
        ));
        if ($car == false) {
            $this->flashSession->error("There is no car with VIN '$vin'");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "edit",
                "params" => array($providedService->getId())
            ));
        }

        $providedService->setCarByVin($vin);
        $providedService->setMilage($this->request->getPost("milage"));
        $providedService->setServiceId($this->request->getPost("service_id"));
        $providedService->setInMs($this->request->getPost("in_ms"));
        $providedService->setRemindStatus($this->request->getPost("remind"));
        $providedService->setMasterId($this->request->getPost("master_id"));
        $providedService->setStartDate($this->request->getPost("start_date"));
        $providedService->setFinishDate($this->request->getPost("finish_date"));
        $providedService->setRemindDate($this->request->getPost("remind_date"));
        $providedService->setRemindKm($this->request->getPost("remind_km"));
        $providedService->setInfo($this->request->getPost("more_info"));

        if (!$providedService->save()) {

            foreach ($providedService->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "edit",
                "params" => array($providedService->getId())
            ));
        }

        $this->flashSession->success("The provided service with id '".$providedService->getId()
            ."' was updated successfully");

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

        $providedService = ProvidedServices::findFirst(array(
            '_id = ?0',
            'bid' => [$id]
        ));
        if (!$providedService) {
            $this->flashSession->error("A provided service was not found");
            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "index"
            ));
        }

        if (!$providedService->delete()) {

            foreach ($providedService->getMessages() as $message){
                $this->flashSession->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "providedservices",
                "action" => "search"
            ));
        }

        $this->flashSession->success("The provided service was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "providedservices",
            "action" => "index"
        ));
    }

}
