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
    public function getUserTopBarMenu()
    {
        //Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if(!$auth) {
            $role = 'Guest';
            $li = '<li><a href="/login">LOGIN</a></li>';
        } else {
            //Get role from auth session variable
            $role = $auth["role"];
            $li = '<li><a href="/logout">LOGOUT '.$role.'</a></li>';
        }
        $html = $li;
        return $html;
    }
}