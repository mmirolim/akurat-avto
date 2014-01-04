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

        $users = Employees::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any employees");
            return $this->dispatcher->forward(array(
                "controller" => "employees",
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
     * Edits a employee
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $employee = Employees::findFirstByid($id);
            if (!$employee) {
                $this->flash->error("employee was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "employees",
                    "action" => "index"
                ));
            }

            $this->view->id = $employee->id;

            $this->tag->setDefault("id", $employee->id);
            $this->tag->setDefault("username", $employee->username);
            $this->tag->setDefault("password", $employee->password);
            $this->tag->setDefault("role_id", $employee->role_id);
            $this->tag->setDefault("fullname", $employee->fullname);
            $this->tag->setDefault("job", $employee->job);
            $this->tag->setDefault("contacts", $employee->contacts);
            $this->tag->setDefault("moreinfo", $employee->moreinfo);
            $this->tag->setDefault("date", $employee->date);

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
        $employee->username = $this->request->getPost("username");
        $employee->password = $this->request->getPost("password");
        $employee->role_id = $this->request->getPost("role_id");
        $employee->fullname = $this->request->getPost("fullname");
        $employee->job = $this->request->getPost("job");
        $employee->contacts = $this->request->getPost("contacts");
        $employee->moreinfo = $this->request->getPost("moreinfo");
        $employee->date = $this->request->getPost("date");


        if (!$employee->save()) {
            foreach ($employee->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "new"
            ));
        }

        $this->flash->success("employee was created successfully");
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
            $this->flash->error("employee does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));
        }

        $employee->id = $this->request->getPost("id");
        $employee->username = $this->request->getPost("username");
        $employee->password = $this->request->getPost("password");
        $employee->role_id = $this->request->getPost("role_id");
        $employee->fullname = $this->request->getPost("fullname");
        $employee->job = $this->request->getPost("job");
        $employee->contacts = $this->request->getPost("contacts");
        $employee->moreinfo = $this->request->getPost("moreinfo");
        $employee->date = $this->request->getPost("date");


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

        $this->flash->success("employee was updated successfully");
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
            $this->flash->error("employee was not found");
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

        $this->flash->success("employee was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "employees",
            "action" => "index"
        ));
    }

}
