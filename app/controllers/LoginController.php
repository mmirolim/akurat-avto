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
        if (isset($user->roleId)) {
            $role = Roles::findFirst($user->roleId);
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
                //First check if username belongs to employee
                $user = Employees::findFirst(array(
                        "username = ?0",
                        "bind" => [$username]
                    ));
                //If false check username in Clients table
                If ($user == false) {
                    //Find the client in the database
                    $user = Clients::findFirst(array(
                        "username = ?0",
                        "bind" => [$username]
                    ));
                }

                if ($user != false) {
                    //Check password hash
                    if ($this->security->checkHash($password, $user->password)) {
                        //Register session for user
                        $this->_registerSession($user);
                        $this->flashSession->success("Welcome ". $user->fullname);
                        //Try to send SMS
                        //$urlSMS = 'http://192.168.1.106:8080/send/?pass=&number=%2B998909862900&data='.urlencode('User '.$user->username.' вошел в личный кабинет '.date('Y-m-d h:i:s')).'&submit=&id=';
                        //$output = file_get_contents($urlSMS);
                        //$this->flashSession->success("Test SMS sending via SMS gateway. Result => ".$output);
                        return $this->response->redirect($this->elements->getAccountRoute());
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