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
        $brand->setName($this->request->getPost("brand"));

        if (!$brand->save()) {
            foreach ($brand->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "carbrands",
                "action" => "new"
            ));
        }

        $this->flashSession->success("Car brand '".$brand->getName()."' was created successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

    }

    /**
     * Saves edited model
     */
    public function saveAction()
    {

    }
}

