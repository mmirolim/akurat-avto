<?php

class CarModelsController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->carBrands = CarBrands::find();
        $this->view->carModels = CarModels::find();
    }

    /**
     * Creates a new model
     */
    public function createAction()
    {
        //TODO move integrity logic to Model
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "carmodels",
                "action" => "new"
            ));
        }

        $carModel = new CarModels();
        $carModel->brandId = $this->request->getPost("brand_id");
        $carModel->name = $this->request->getPost("model");

        if (!$carModel->save()) {
            foreach ($carModel->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "carmodels",
                "action" => "new"
            ));
        }

        $this->flashSession->success("Car model '$carModel->name' was created successfully");
        return $this->response->redirect("/".strtolower($this->session->get("auth")["role"])."/".strtolower($this->session->get("auth")["username"]));
    }

    /**
     * Saves edited model
     */
    public function saveAction()
    {

    }


}

