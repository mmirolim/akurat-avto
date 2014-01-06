<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 1/6/14
 * Time: 4:28 PM
 */

use Phalcon\Mvc\Model\Criteria;

class LogoutController extends ControllerBase
{
    public function indexAction()
    {
        $this->session->destroy();

        //Do HTTP Redirect to frontpage
        return $this->response->redirect('/');

        //Disable the view to avoid rendering or return 'response'
        //$this->view->disable();
    }
}