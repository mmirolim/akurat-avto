<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Db\RawValue as RawValue;

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
            $parameters['id'] = $this->request->getPost("id");
            $parameters['username'] = $this->request->getPost("username");
            $parameters['fullname'] = $this->request->getPost("fullname");
            $this->persistent->parameters = $parameters;
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "_id";

        $clients = Clients::find(array(
            '_id = :id: OR _username LIKE :username: OR _fullname LIKE :fullname: ORDER BY :order:',
            'bind' => $parameters
        ));
        if (count($clients) == 0) {
            $this->flashSession->notice("The search did not find any clients");
        }

        $paginator = new Paginator(array(
            "data" => $clients,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }

    /**
     * Displays the creation form
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
            $this->tag->setDefault("contact_email", $client->contactEmail);
            $this->tag->setDefault("contact_phone", $client->contactPhone);
            $this->tag->setDefault("notify", $client->notify);
            $this->tag->setDefault("more_info", $client->moreInfo);
            
        }
    }

    /**
     * Creates a new client
     */
    public function createAction()
    {
        //TODO move integrity logic to Model
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "index"
            ));
        }

        $client = new Clients();

        $username = $this->request->getPost("username");
        //Check if same username is available
        $checkInClients = Clients::findFirst(array(
            '_username = ?0',
            'bind' => [$username]
        ));
        $checkInEmployees = Employees::findFirst(array(
            '_username = ?0',
            'bind' => [$username]
        ));
        if ($checkInClients != false || $checkInEmployees != false) {
            $this->flashSession->error("This username already taken");
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "new"
            ));
        }

        $client->setUsername($username);
        $client->setPassword($this->request->getPost("password"));
        $client->setFullname($this->request->getPost("fullname"));
        $client->setPhone($this->request->getPost("contact_phone"));
        $client->setEmail($this->request->getPost("contact_email"));
        $client->setRegDate();
        $client->setInfo($this->request->getPost("more_email"));

        if (!$client->save()) {
            foreach ($client->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "new"
            ));
        }

        $this->flashSession->success("Client '".$client->getUsername()."' was created successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

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
        if($client->password != $this->security->hash($this->request->getPost("password"))) {
            $client->password = $this->security->hash($this->request->getPost("password"));
        }
        $client->fullname = $this->request->getPost("fullname");
        $client->contactPhone = $this->request->getPost("contact_phone");
        if ($this->request->getPost("contact_email")) {
            $client->contactEmail = $this->request->getPost("contact_email");
        } else {
            $client->contactEmail = new RawValue('default');
        }
        if ($this->request->getPost("more_info")) {
            $client->moreInfo = $this->request->getPost("more_info");
        } else {
            $client->moreInfo = new RawValue('default');
        }


        if (!$client->save()) {

            foreach ($client->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "clients",
                "action" => "edit",
                "params" => array($client->id)
            ));
        }

        $this->flashSession->success("Client '$client->username' was updated successfully");
        return $this->response->redirect($this->elements->getAccountRoute());

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
            $this->flash->error("Client was not found");
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

        $this->flash->success("Client was deleted successfully");
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
            //TODO remove redundant redirects
            return $this->response->redirect($this->elements->getAccountRoute());
        }
        //Check that user is a client
        if($this->session->get("auth")["role"] == 'Client') {
            $clientId = $this->session->get("auth")["id"];
            $clientUsername = $this->session->get("auth")["username"];
        } else {
            $this->flashSession->error("Your should be Client to edit that data");
            return $this->response->redirect($this->elements->getAccountRoute());
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
            return $this->response->redirect($this->elements->getAccountRoute());
        }

        //Get client info
        $client = Clients::findFirst(array(
            '_id = ?0',
            'bind' => [$id]));

        //TODO Refactor to check what is updated and place all error to one bin and don't send all client information

        if (!$client) {
            $this->flash->error("Client does not exist");
            return $this->response->redirect($this->elements->getAccountRoute());
        }
        //TODO use ternary if
        if($this->request->getPost("contact_phone")) {
            $client->setPhone($this->request->getPost("contact_phone"));
        }
        if($this->request->getPost("contact_email")) {
        $client->setEmail($this->request->getPost("contact_email"));
        }
        if($this->request->getPost("more_info")) {
            $client->setInfo($this->request->getPost("more_info"));
        }
        $passwordChangeText = 'Secret';
        if ($this->request->getPost("new_pass") && $this->request->getPost("current_pass")) {
                if ($this->security->checkHash($this->request->getPost("current_pass"), $client->getPassword())) {
                    $client->setPassword($this->request->getPost("new_pass"));
                    $passwordChangeText = "Success";
                } else {
                    $passwordChangeText = "Current password wrong";
                }
        }

        $notifyStatus = $client->getNotify();
        if ($this->request->getPost("notify")) {
            if ($this->request->getPost("notify") == "Yes") {
                $client->setNotify(1);
                $notifyStatus = "Yes";
            } else {
                $client->setNotify(0);
                $notifyStatus = "No";
            }
        }

        if (!$client->save()) {

            foreach ($client->getMessages() as $message) {
                $this->flashSession->error($message);
            }

            return $this->response->redirect($this->elements->getAccountRoute());
        }

        $stdClient = new stdClass();
        $stdClient->phone = $client->getPhone();
        $stdClient->email = $client->getEmail();
        $stdClient->password = $passwordChangeText;
        $stdClient->notify =  $notifyStatus;
        $stdClient->info = $client->getInfo();

        //Json encode and don't escape UTF8 (only for 5.4)
        echo json_encode($stdClient,JSON_UNESCAPED_UNICODE);
        $this->view->disable();

    }
}
