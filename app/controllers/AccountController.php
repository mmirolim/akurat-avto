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

    /**
     * Set common variables in all actions
     */
    protected function setCommonVars() {
        $this->view->setVars(array(
            'employee' => Employees::findFirstByUsername($this->session->get("auth")["username"]),
            'employees' => Employees::inArrayById(),
            'carServices' => CarServices::inArrayById(),
            'providedServices' => ProvidedServices::find()
        ));
    }

    /**
     * Shows View for client role
     *
     */
    public function clientAction()
    {
        //Get client info
        $this->view->client = Clients::findFirstByUsername($this->session->get("auth")["username"]);
        $this->setCommonVars();

    }

    /**
     * Shows View for employee role
     *
     */
    public function employeeAction()
    {
        $this->setCommonVars();
    }

    /**
     * Shows View for master role
     *
     */
    public function masterAction()
    {
        $this->setCommonVars();
    }

    /**
     * Shows View for boss role
     *
     */
    public function bossAction()
    {
        $this->setCommonVars();
    }

    /**
     * Shows View for admin role
     *
     */
    public function adminAction()
    {

        $this->setCommonVars();
    }


}