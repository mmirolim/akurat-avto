<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl;

class Security extends Plugin
{
    private function _getAcl()
    {
        // For performance store serialized acl object somewhere
        //Check whether acl data already exist
        $aclFile = __DIR__ . '/../../app/cache/acl.data';
        if(!file_exists($aclFile)) {
            //Create the ACL
            $acl = new Phalcon\Acl\Adapter\Memory();

            //The default action is DENY access
            $acl->setDefaultAction(Phalcon\Acl::DENY);

            //Register all roles and guests
            $roles = array(
                'admin' => new Phalcon\Acl\Role('Admin'),
                'boss' => new Phalcon\Acl\Role('Boss'),
                'master' => new Phalcon\Acl\Role('Master'),
                'employee' => new Phalcon\Acl\Role('Employee'),
                'client' => new Phalcon\Acl\Role('Client'),
                'guest' => new Phalcon\Acl\Role('Guest')
            );
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            //Private area resources (backend)
            $privateResources = array(
                'roles' => array('index','search','create','new','edit','save','delete'),
                'providedservices' => array('index','search','create','new','edit','save','delete'),
                'employees' => array('index','search','create','new','edit','save','delete'),
                'clients' => array('index','search','create','new','edit','save','delete','updateOwn'),
                'cars' => array('index','search','create','new','edit','save','delete','updateOwn','vin'),
                'carservices' => array('index','search','create','new','edit','save','delete'),
                'account' => array('index','view','search','create','new','edit','save','delete'),
                'profiler' => array('index')
            );
            foreach ($privateResources as $resource=>$action) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $action);
            }

            //Public area resources (frontend)
            $publicResources = array(
                'index' => array('index'),
                'login' => array('index'),
                'logout' => array('index')
            );
            foreach ($publicResources as $resource=>$action) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $action);
            }

            //Define array of resources and action accessible by Boss
            $bossResources = array(
                'providedservices' => array('index','search','create','new','edit','save','delete'),
                'employees' => array('index','search','create','new','edit','save','delete'),
                'clients' => array('index','search','create','new','edit','save','delete'),
                'cars' => array('index','search','create','new','edit','save','delete','vin'),
                'carservices' => array('index','search','create','new','edit','save','delete'),
                'account' => array('index','view'),
            );

            //Define array of resources and action accessible by Master
            $masterResources = array(
                'providedservices' => array('index','search','create','new','edit','save'),
                'clients' => array('index','search','create','new','edit','save'),
                'cars' => array('index','search','create','new','edit','save','vin'),
                'account' => array('index','view'),
            );

            //Define array of resources and action accessible by Employee
            $employeeResources = array(
                'providedservices' => array('index','search'),
                'clients' => array('index','search'),
                'cars' => array('index','search','vin'),
                'account' => array('index','view'),
            );
            //Define array of resources and action accessible by Client
            $clientResources = array(
                'account' => array('index','view'),
                'clients' => array('updateOwn'),
                'cars' => array('updateOwn','vin')
            );

            //Grant access to Admin
            foreach ($privateResources as $resource=>$actions) {
                foreach ($actions as $action) {
                    $acl->allow('Admin', $resource, $action);
                }
            }
            //Grant access to Boss
            foreach ($bossResources as $resource=>$actions) {
                foreach ($actions as $action) {
                    $acl->allow('Boss', $resource, $action);
                }
            }
            //Grant access to Master
            foreach ($masterResources as $resource=>$actions) {
                foreach ($actions as $action) {
                    $acl->allow('Master', $resource, $action);
                }
            }
            //Grant access to Employee
            foreach ($employeeResources as $resource=>$actions) {
                foreach ($actions as $action) {
                    $acl->allow('Employee', $resource, $action);
                }
            }
            //Grant access to Client
            foreach ($clientResources as $resource=>$actions) {
                foreach ($actions as $action) {
                    $acl->allow('Client', $resource, $action);
                }
            }
            //Grant access to Guest and others
            foreach ($roles as $role) {
                foreach ($publicResources as $resource=>$actions) {
                         $acl->allow($role->getName(), $resource,'*');
                }
            }

             //Store serialized list into plain file
            file_put_contents($aclFile, serialize($acl));
        } else {

            //Restore acl object from serialized file
            $acl = unserialize(file_get_contents($aclFile));
        }
        return $acl;
    }
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        //Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if(!$auth) {
            $role = 'Guest';
        } else {
            //Get role from auth session variable
            $role = $auth["role"];
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        //Obtain the ACL list
        $acl = $this->_getAcl();

        //Check if the role have access to the controller (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);
        if($allowed != Acl::ALLOW) {
            //If he doesn't have access forward him to the index controller
            $this->flashSession->error("You don't have access to ".$controller." page");

            // forward user to frontpage via $this->dispatcher using $dispatcher will create infinite loop
            $this->response->redirect('/');
            //Returning "false" we tell to the dispatcher to stop the current operation
            return false;
        }

    }

}
