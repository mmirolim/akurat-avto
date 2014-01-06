<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 1/5/14
 * Time: 3:45 PM
 */
use Phalcon\Mvc\Model\Criteria;

class LoginController extends ControllerBase
{
    private function _registerSession($user)
    {
        if (isset($user->role_id)) {
            $role = Roles::findFirst($user->role_id);
            $role = $role->role;
        } else {
            $role = 'Client';
        }
        $this->session->set('auth', array(
            'id' => $user->id,
            'username' => $user->username,
            'role' => $role
        ));
    }
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    public function startAction()
    {
        if($this->request->isPost()) {
              //Receiving the variables sent by POST
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            //Should be not empty
            if($username && $password) {
                //Find the user in the database
                $user = Clients::findFirst(array(
                    "username = :username:",
                    "bind" => array('username' => $username)
                ));
                if($user == false) {
                    $user = Employees::findFirst(array(
                        "username = :username:",
                        "bind" => array('username' => $username)
                    ));
                }
                if ($user != false) {
                    //Check password hash
                    if ($this->security->checkHash($password, $user->password)) {
                        //Register session for user
                        $this->_registerSession($user);
                        $this->flash->success("Welcome ". $user->fullname);
                    } else {
                        $this->flash->error("Wrong username or/and password");
                    }
                } else {
                    $this->flash->error("Wrong username or/and password");
                }
            } else {
                $this->flash->error("Username and Password should be not empty");
            }
        }
        //Forward to the login form again
        return $this->dispatcher->forward(array(
            'controller' => 'login',
            'action' => 'index'
        ));
    }
    public function endAction()
    {
        $this->session->destroy();

    }
}