<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

class ProfilerController extends ControllerBase
{
    public function indexAction()
    {
        echo 'PROFILE QUERIES<br />';

        $eventsManager = new EventsManager();

        $profiler = new DbProfiler();

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($profiler) {
            if ($event->getType() == 'beforeQuery') {
                //Start a profile with the active connection
                $profiler->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                //Stop the active profile
                $profiler->stopProfile();
            }
        });

        //Assign the events manager to the db connection
        $this->db->setEventsManager($eventsManager);

        echo 'RUN QUERIES<br/>';
        echo '<code>ProvidedServices::find()</code><br/>';
        $pS = ProvidedServices::find(array('order' =>'startDate DESC'));
        echo 'Results: '. count($pS) .'<br/>';

        //Get the generated profiles from the profiler
        $profiles = $profiler->getProfiles();

        foreach ($profiles as $profile) {
            echo "SQL Statement: <code>", $profile->getSQLStatement(), "</code><br/>";
            echo "Start Time: <code>", $profile->getInitialTime(), "</code><br/>";
            echo "Final Time: <code>", $profile->getFinalTime(), "</code><br/>";
            echo "Total Elapsed Time: <code>", $profile->getTotalElapsedSeconds(), "</code><br/>";
        }
        foreach ($pS as $s) {
            echo $s->startDate.'<br/>';
        }
    }
}