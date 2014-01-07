<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 1/6/14
 * Time: 11:55 AM
 */

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Mvc\Model\Resultset,
    Phalcon\Paginator\Adapter\Model as Paginator;

class AccountController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function viewAction()
    {
        $param = $this->router->getParams();

        //Check if only one parameter
        if(count($param) > 1) {
            //TODO fix why not shown message
            $this->flashSession->error("Wrong number of parameters in account");
            return $this->response->redirect("/");
        }

        //Get username
        $username = $param[0];

        //Restrict viewing account to owner
        $usernameInSession = $this->session->get("auth")["username"];
        if ($username !== $usernameInSession) {
            $this->flashSession->error("Wrong Account");
            return $this->response->redirect("/");
        }

        //Get role and use appropriate action
        $role = $this->session->get("auth")["role"];
        $this->view->employees = Employees::find(array("columns" => "id, fullname, job, contacts"));
        $this->view->carservices = Carservices::find();
        switch($role)
        {
            case 'Client':
                $this->_getClientData($username);
                break;
            case 'Employee':
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

        //Get client data
        /*$user = Clients::findFirst(array(
            "username = :username:",
            "bind" => array("username" => $username)
        ));
        $this->view->client = $user;

            //Get client cars
        $cars = Cars::find(array(
            "owner_id = :owner:",
            "bind" => array("owner" => $user->id)
        ));
        $this->view->cars = $cars;

        //Get provided services for all cars
        foreach($cars as $car) {
            $providedServices[] = Providedservices::find(array(
                "car_id = :car:",
                "bind" => array("car" => $car->id)
            ));
        }
        $this->view->providedservices = $providedServices;
        */
        $client = new stdClass();
        $client->info = Clients::findFirst("username = '".$username."'");
        $cars = $client->info->getCars()->setHydrateMode(Resultset::HYDRATE_RECORDS);
        foreach($cars as $car) {
            $car->providedServices = $car->getProvidedservices()->setHydrateMode(Resultset::HYDRATE_RECORDS);
        }
        $client->cars = $cars;
        $this->view->client = $client;

    }

    protected function _getEmployeeData($username)
    {

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