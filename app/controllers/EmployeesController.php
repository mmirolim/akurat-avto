<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class EmployeesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $numberPage = 1;

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $employees = Employees::find($parameters);
        $this->view->roles = Roles::find();
        if (count($employees) == 0) {
            $this->flash->notice("There is no employees");
        }
        $paginator = new Paginator(array(
            "data" => $employees,
            "limit"=> 100,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }

    /**
     * Searches for employees
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Employees", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $employees = Employees::find($parameters);
        if (count($employees) == 0) {
            $this->flash->notice("The search did not find any employees");
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $employees,
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
     * Edits a employee
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $this->view->roles = Roles::find();
        if (!$this->request->isPost()) {

            $employee = Employees::findFirstByid($id);
            if (!$employee) {
                $this->flash->error("An Employee was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "employees",
                    "action" => "index"
                ));
            }

            $this->view->id = $employee->id;
            $this->tag->setDefault("id", $employee->id);
            $this->tag->setDefault("username", $employee->username);
            $this->tag->setDefault("password", $employee->password);
            $this->tag->setDefault("role_id", $employee->roleId);
            $this->tag->setDefault("fullname", $employee->fullname);
            $this->tag->setDefault("job", $employee->job);
            $this->tag->setDefault("contacts", $employee->contacts);
            $this->tag->setDefault("more_info", $employee->moreInfo);
            $this->tag->setDefault("works_since", $employee->worksSince);

        }
    }

    /**
     * Creates a new employee
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));
        }

        $employee = new Employees();

        $employee->id = $this->request->getPost("id");
        $username = $this->request->getPost("username");
        //Check if this username is already in use as client username
        $checkUsername = Clients::findFirst(array(
            'username = ?0',
            'bind' => $username
        ));
        if ($checkUsername != false) {
            $this->flash->error("This username is already taken");
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "new"
            ));
        }
        $employee->password = $this->security->hash($this->request->getPost("password"));
        $employee->roleId = $this->request->getPost("role_id");
        $employee->fullname = $this->request->getPost("fullname");
        $employee->job = $this->request->getPost("job");
        $employee->contacts = $this->request->getPost("contacts");
        $employee->moreInfo = $this->request->getPost("more_info");
        $employee->worksSince = $this->request->getPost("works_since");


        if (!$employee->save()) {
            foreach ($employee->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "new"
            ));
        }

        $this->flash->success("The Employee was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "employees",
            "action" => "index"
        ));

    }

    /**
     * Saves a employee edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $employee = Employees::findFirstByid($id);
        if (!$employee) {
            $this->flash->error("An employee does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));
        }

        $employee->id = $this->request->getPost("id");
        $employee->username = $this->request->getPost("username");
        if($employee->password != $this->request->getPost("password")) {
            $employee->password = $this->security->hash($this->request->getPost("password"));
        }
        $employee->roleId = $this->request->getPost("role_id");
        $employee->fullname = $this->request->getPost("fullname");
        $employee->job = $this->request->getPost("job");
        $employee->contacts = $this->request->getPost("contacts");
        $employee->moreInfo = $this->request->getPost("more_info");
        $employee->worksSince = $this->request->getPost("works_since");

         if (!$employee->save()) {

            foreach ($employee->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "edit",
                "params" => array($employee->id)
            ));
        }

        $this->flash->success("The Employee's info was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "employees",
            "action" => "index"
        ));

    }

    /**
     * Deletes a employee
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $employee = Employees::findFirstByid($id);
        if (!$employee) {
            $this->flash->error("An Employee was not found");
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));
        }

        if (!$employee->delete()) {

            foreach ($employee->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "search"
            ));
        }

        $this->flash->success("The Employee was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "employees",
            "action" => "index"
        ));
    }

}
