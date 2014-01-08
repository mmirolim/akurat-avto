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

        //TODO cache employees and services resultsets
        //Get all employees
        $this->view->employees = Employees::find(array("columns" => "id, fullname, job, contacts"));
        //Get all services
        $this->view->carservices = Carservices::find();

        //Get appropriate data according to users role
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
        $client = new stdClass();
        //HYDRATE client cars as Clients object so user can easily modify own data if required
        $client->info = Clients::findFirst(array(
            "username = '".$username."'",
            'hydration' => Resultset::HYDRATE_RECORDS
        ));
        //Get client's cars info
        //HYDRATE client cars as Cars object so user can easily modify own cars data if required
        $cars = $client->info->getCars()->setHydrateMode(Resultset::HYDRATE_RECORDS);
        //Get all provided services to client
        foreach($cars as $car) {
            //HYDRATE provided services as stDClass objects just to read data not to edit
            //TODO order by startdate by default
            $car->providedServices = $car->getProvidedservices()->setHydrateMode(Resultset::HYDRATE_OBJECTS);
        }
        $client->cars = $cars;
        //Make available in views
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