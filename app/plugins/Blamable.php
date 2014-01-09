<?php

use Phalcon\Mvc\Model\Behavior,
    Phalcon\Mvc\Model\BehaviorInterface;

class Blamable extends Behavior implements BehaviorInterface
{
    public function notify($eventType, $model)
    {
        //Log all events
        //TODO log only required events

        //Get username from session
       // $userName = $this->session->get("auth")["username"];
        $userName = $_SESSION["auth"]["username"];

        //Store in a log the username, event type and primary key
        file_put_contents(__DIR__ . '/../../app/logs/blamable-log.txt',$userName .' '. $eventType .' '. serialize($model));

    }
}