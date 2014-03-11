<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        throw new InvalidArgumentException('Exception to test Whoops');
    }

}

