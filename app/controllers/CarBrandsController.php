<?php

class CarBrandsController extends \Phalcon\Mvc\Controller
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
    }

    /**
     * Creates a new model
     */
    public function createAction()
    {

        //TODO move integrity logic to Model
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "carbrands",
                "action" => "new"
            ));
        }

        $brand = new CarBrands();
        $brand->name = $this->request->getPost("brand");

        if (!$brand->save()) {
            foreach ($carModel->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "carbrands",
                "action" => "new"
            ));
        }

        $this->flashSession->success("Car brand '$brand->name' was created successfully");
        return $this->response->redirect("/".strtolower($this->session->get("auth")["role"])."/".strtolower($this->session->get("auth")["username"]));

    }

    /**
     * Saves edited model
     */
    public function saveAction()
    {

    }
}

