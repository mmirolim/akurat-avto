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
                        $this->flashSession->success("Welcome ". $user->fullname);
                        return $this->response->redirect("/account/".$user->username."/view");
                    } else {
                        $this->flashSession->error("Wrong username or/and password");
                    }
                } else {
                    $this->flashSession->error("Wrong username or/and password");
                }
            } else {
                $this->flashSession->error("Username and Password should be not empty");
            }

            //Forward to the login form again
            return $this->response->redirect("/login");
        }

    }

 }