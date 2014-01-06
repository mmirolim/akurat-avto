<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 1/6/14
 * Time: 11:55 AM
 */

use Phalcon\Mvc\Model\Criteria,
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
    }
}