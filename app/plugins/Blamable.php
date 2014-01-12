<?php

use Phalcon\Mvc\Model\Behavior,
    Phalcon\Mvc\Model\BehaviorInterface;

class Blamable extends Behavior implements BehaviorInterface
{
    public function notify($eventType, $model)
    {

        switch ($eventType) {

            //Event type to log
            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':

                //Get username from session
                $userName = $_SESSION["auth"]["username"];
                //Remove sensitive data from logged information
                if (isset($model->password)) {
                    $model->password = '';
                }
                //Write to new log every week
                //TODO rotate logs the right way
                $week = round(time()/604800);
                //Add current date and time to log
                $date = date('Y-m-d h:m:s');
                //Store in a log the username, event type serialized model
                file_put_contents(__DIR__ . '/../../app/logs/blamable-log-'.$week.'.txt', "\n" .$date.' userName='.$userName .' '. 'event='.$eventType .' '. serialize($model),FILE_APPEND);
                break;
            default:
                //Ignore the rest of events
        }
    }
}