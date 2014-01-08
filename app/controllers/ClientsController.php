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
            $this->tag->setDefault("username", $client->username);
            $this->tag->setDefault("password", $client->password);
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
        $client->username = $this->request->getPost("username");
        $client->password = $this->security->hash($this->request->getPost("password"));
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
        $client->username = $this->request->getPost("username");
        if($client->password != $this->request->getPost("password")) {
            $client->password = $this->security->hash($this->request->getPost("password"));
        }
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

    /**
     * Saves a client info edited by client
     * TODO refactor function to be DRY
     */
    public function updateOwnAction()
    {
        $clientUsername = $this->session->get("auth")["username"];
        if (!$this->request->isPost()) {
            $this->flashSession->error("Should be post to update own data");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Check that user is a client
        if($this->session->get("auth")["role"] == 'Client') {
            $clientId = $this->session->get("auth")["id"];
            $clientUsername = $this->session->get("auth")["username"];
        } else {
            $this->flashSession->error("Your should be Client to edit that data");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }
        //Get car id for update
        $id = $this->request->getPost("id");

        //Check if client is car owner
        $isOwnInfo = false;
        if($clientId == $id) {
            $isOwnInfo = true;
        }
        if (!$isOwnInfo) {
            //Dispatch if not own car
            $this->flashSession->error("Only own info can be edited");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }

        //Get client info
        $client = Clients::findFirstById($id);

        if (!$client) {
            $this->flash->error("Client does not exist");
            return $this->response->redirect("/account/".$clientUsername."/view");
        }

        if($this->request->getPost("contactphone")) {
            $client->milage = $this->request->getPost("contactphone");
        }
        if($this->request->getPost("contactemail")) {
            $client->dailymilage = $this->request->getPost("contactemail");
        }
        if($this->request->getPost("moreinfo")) {
            $client->moreinfo = $this->request->getPost("moreinfo");
        }


        if (!$client->save()) {

            foreach ($client->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->response->redirect("/account/".$clientUsername."/view");
        }


        echo json_encode($client);
        $this->view->disable();

    }
}
