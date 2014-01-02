<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for users
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Users", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $users = Users::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $users,
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
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $user = Users::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "users",
                    "action" => "index"
                ));
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("username", $user->username);
            $this->tag->setDefault("fullname", $user->fullname);
            $this->tag->setDefault("role", $user->role);
            $this->tag->setDefault("job", $user->job);
            $this->tag->setDefault("contacts", $user->contacts);
            $this->tag->setDefault("moreinfo", $user->moreinfo);
            $this->tag->setDefault("date", $user->date);
            
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "index"
            ));
        }

        $user = new Users();

        $user->id = $this->request->getPost("id");
        $user->username = $this->request->getPost("username");
        $user->fullname = $this->request->getPost("fullname");
        $user->role = $this->request->getPost("role");
        $user->job = $this->request->getPost("job");
        $user->contacts = $this->request->getPost("contacts");
        $user->moreinfo = $this->request->getPost("moreinfo");
        $user->date = $this->request->getPost("date");
        

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "new"
            ));
        }

        $this->flash->success("user was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "users",
            "action" => "index"
        ));

    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "index"
            ));
        }

        $user->id = $this->request->getPost("id");
        $user->username = $this->request->getPost("username");
        $user->fullname = $this->request->getPost("fullname");
        $user->role = $this->request->getPost("role");
        $user->job = $this->request->getPost("job");
        $user->contacts = $this->request->getPost("contacts");
        $user->moreinfo = $this->request->getPost("moreinfo");
        $user->date = $this->request->getPost("date");
        

        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "edit",
                "params" => array($user->id)
            ));
        }

        $this->flash->success("user was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "users",
            "action" => "index"
        ));

    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "index"
            ));
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "search"
            ));
        }

        $this->flash->success("user was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "users",
            "action" => "index"
        ));
    }

}
