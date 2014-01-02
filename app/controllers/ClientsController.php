<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class ClientsController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for clients
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Clients", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $clients = Clients::find($parameters);
        if (count($clients) == 0) {
            $this->flash->notice("The search did not find any clients");
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $clients,
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
     * Edits a client
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $client = Clients::findFirstByid($id);
            if (!$client) {
                $this->flash->error("client was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "clients",
                    "action" => "index"
                ));
            }

            $this->view->id = $client->id;

            $this->tag->setDefault("id", $client->id);
            $this->tag->setDefault("fullname", $client->fullname);
            $this->tag->setDefault("contactemail", $client->contactemail);
            $this->tag->setDefault("contactphone", $client->contactphone);
            $this->tag->setDefault("regdate", $client->regdate);
            $this->tag->setDefault("moreinfo", $client->moreinfo);
            
        }
    }

    /**
     * Creates a new client
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "index"
            ));
        }

        $client = new Clients();

        $client->id = $this->request->getPost("id");
        $client->fullname = $this->request->getPost("fullname");
        $client->contactemail = $this->request->getPost("contactemail");
        $client->contactphone = $this->request->getPost("contactphone");
        $client->regdate = $this->request->getPost("regdate");
        $client->moreinfo = $this->request->getPost("moreinfo");
        

        if (!$client->save()) {
            foreach ($client->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "new"
            ));
        }

        $this->flash->success("client was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "clients",
            "action" => "index"
        ));

    }

    /**
     * Saves a client edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $client = Clients::findFirstByid($id);
        if (!$client) {
            $this->flash->error("client does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "index"
            ));
        }

        $client->id = $this->request->getPost("id");
        $client->fullname = $this->request->getPost("fullname");
        $client->contactemail = $this->request->getPost("contactemail");
        $client->contactphone = $this->request->getPost("contactphone");
        $client->regdate = $this->request->getPost("regdate");
        $client->moreinfo = $this->request->getPost("moreinfo");
        

        if (!$client->save()) {

            foreach ($client->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "edit",
                "params" => array($client->id)
            ));
        }

        $this->flash->success("client was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "clients",
            "action" => "index"
        ));

    }

    /**
     * Deletes a client
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $client = Clients::findFirstByid($id);
        if (!$client) {
            $this->flash->error("client was not found");
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "index"
            ));
        }

        if (!$client->delete()) {

            foreach ($client->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "search"
            ));
        }

        $this->flash->success("client was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "clients",
            "action" => "index"
        ));
    }

}
