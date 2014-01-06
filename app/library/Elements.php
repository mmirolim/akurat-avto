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
        $navLeft .='<li class="call-us-link">Call Us (99893) 124-12-12</li>';
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
            $li = '<li><a href="/logout">Logout</a></li>';
        }
        $navRight .= $li.'</ul>';

        $html = $navLeft.$navRight;
        return $html;
    }
}