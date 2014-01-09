<?php

use Phalcon\Mvc\Model\Behavior,
    Phalcon\Mvc\Model\BehaviorInterface;

class Blameable extends Behavior implements BehaviorInterface
{
    public function notify($eventType, $model)
    {
        //Log all events
        //TODO log only required events

        //Get username
        $userName = $this->session->get("auth")["username"];

        //Store in a log the username, event type and primary key
        file_put_contents(__DIR__ . '/../../app/logs/blameable-log.txt',$userName .' '. $eventType .' '. $model->id);

    }
}