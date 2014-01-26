<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 1/6/14
 * Time: 11:55 AM
 */

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AccountController extends ControllerBase
{
    public function indexAction()
    {
        //TODO harden security
        $this->persistent->username = $this->session->get("auth")["username"];

        //Get all employees
        $this->view->employees = Employees::inArrayById();

        //Get all services
        $this->view->carServices = CarServices::inArrayById();

        //Get appropriate data according to users role
        switch($this->session->get("auth")["role"])
        {
            case 'Client':
                //Call clientAction
                $this->clientAction();
                //Show view of clientAction
                $this->view->pick("account/client");
                break;
            case 'Employee':
                $this->employeeAction();
                $this->view->pick("account/employee");
                break;
            case 'Master':
                break;
            case 'Boss':
                break;
            case 'Admin':
                break;
            default:
                $this->flash->error("Wrong Role");
                return $this->response->redirect("/");
        }
    }

    /**
     * Shows View for client role
     *
     */
    protected function clientAction()
    {
        //Get client info
        $this->view->client= Clients::findFirstByUsername($this->persistent->username);

    }

    /**
     * Shows View for employee role
     *
     */
    protected function employeeAction()
    {
        //Get employee info
        $this->view->employee = Employees::findFirstByUsername($this->persistent->username);
    }

    /**
     * Shows View for master role
     *
     */
    protected function masterAction()
    {
        //Get employee info
        $this->view->employee = Employees::findFirstByUsername($this->persistent->username);
    }

    /**
     * Shows View for boss role
     *
     */
    protected function bossAction()
    {
        //Get employee info
        $this->view->employee = Employees::findFirstByUsername($this->persistent->username);
    }

    /**
     * Shows View for admin role
     *
     */
    protected function adminAction()
    {
        //Get employee info
        $this->view->employee = Employees::findFirstByUsername($this->persistent->username);
    }


}