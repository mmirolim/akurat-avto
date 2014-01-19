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

    }

    public function viewAction()
    {
        //Get username
        $username = $this->router->getParams()[0];

        //Restrict viewing account to owner
        $usernameInSession = $this->session->get("auth")["username"];
        if ($username !== $usernameInSession) {
            $this->flashSession->error("Wrong Account");
            return $this->response->redirect("/");
        }

        //Get role and use appropriate action
        $role = $this->session->get("auth")["role"];
        $this->view->currentUserRole = $role;

        //Get all employees and cache it
        $this->view->employees = Employees::inArrayById(array(
            "columns" => "id, fullname, job, contacts",
            //"cache" => array("key" => "employees-list", "lifetime" => 300),
        ));

        //Get all services and cache it
        $this->view->carServices = CarServices::inArrayById( array(
            //"cache" => array("key" => "car-services-list", "lifetime" => 300),
        ));

        //Get appropriate data according to users role
        switch($role)
        {
            case 'Client':
                $this->_getClientData($username);
                break;
            case 'Employee':
                $this->_getEmployeeData($username);
                break;
            case 'Master':
                break;
            case 'Boss':
                break;
            case 'Admin':
                break;
            default:
                $this->flashSession->error("Wrong Role");
                return $this->response->redirect("/");
        }
    }

    protected function _getClientData($username)
    {
        $client = Clients::findFirst(array(
            "username = '".$username."'",
            'hydration' => Resultset::HYDRATE_OBJECTS
        ));

        $cars = $client->getCars()->setHydrateMode(Resultset::HYDRATE_RECORDS);

        $client->cars = $cars;
        //Make available in views
        $this->view->client = $client;

    }

    protected function _getEmployeeData($username)
    {
        //Get employee info
        $employee = Employees::findFirst("username = '".$username."'");
        $this->view->employee = $employee;
    }

    protected function _getMasterData($username)
    {

    }

    protected function _getBossData($username)
    {

    }

    protected function _getAdminData($username)
    {

    }

}