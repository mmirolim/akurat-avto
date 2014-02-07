<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 1/6/14
 * Time: 3:38 PM
 */

use Phalcon\Mvc\User\Component;

class Elements extends Component
{
    public function getTopBarMenu()
    {
        //Create top nav left
        $navLeft = '<ul class="top-nav-left">';
        $navLeft .='<li class="home-link"><h3><a href="/">AKURAT AVTO</a></h3></li>';
        $navLeft .='<li class="facebook-link">Facebook</li>';
        $navLeft .='<li class="twitter-link">Twitter</li>';
        $navLeft .='<li class="google-link">Google+</li>';
        $navLeft .='<li class="call-us-link button">Call Us (99893) 124-12-12</li>';
        $navLeft .='</ul>';
        //Create top nav right
        $navRight ='<ul class="top-nav-right">';

        //Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if(!$auth) {
            $role = 'Guest';
            $li = '<li class="login-link"><a href="/login">Login</a></li>';
        } else {
            //Get role from auth session variable
            $role = $auth["role"];
            $li  = '<li><a href="/'.strtolower($auth["role"]).'/'.$auth["username"].'">Account</a></li>';
            $li .= '<li><a href="/logout" id="logout">Logout</a></li>';
        }
        $navRight .= $li.'</ul>';

        $html = $navLeft.$navRight;
        return $html;
    }

    public function getBarcodeLink()
    {
        return '<a class="button" href="zxing://scan/?ret=http%3A%2F%2Fakurat.auto:8080%2Fcars%2Fvin%2F%7BCODE%7D%2F">Find car by QR Code</a>';
    }

    public function getCancelButton()
    {
        //TODO do with cookies and redirects
        return '<span class="button small" id="cancel" onclick="window.history.back()">Cancel</span>';
    }

    public function getAccountRoute()
    {
        return strtolower('/'.$this->session->get("auth")["role"].'/'.$this->session->get("auth")["username"]);
    }

    public function getEditLinks($id = null, $controller = null)
    {
        //Return edit and delete links according to ACL rules for given role, controller
        $html = '';
        if (is_null($id)) {
            return $html;
        }
        $params = array('role' => $this->session->get("auth")['role']);
        if (is_null($controller)) {
            $params['controller'] = $this->dispatcher->getControllerName();
        } else {
            $params['controller'] = $controller;
        }

        $params['action'] = 'edit';
        if (Security::isActionAllowed($params)) {
            $html .='<a class="edit-link" href="/'.$params['controller'].'/'.$params['action'].'/'.$id.'">Edit</a>';
        }
        $params['action'] = 'delete';
        if (Security::isActionAllowed($params)) {
            $html .='<a class="delete-link" href="/'.$params['controller'].'/confirm/'.$id.'">Delete</a>';
        }

        return $html;

    }
}