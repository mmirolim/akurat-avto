<?php
//Create the router
$router = new \Phalcon\Mvc\Router();

//Define a "/account" route
$router->add("/account/:params/:action", array(
    "controller" => "account",
    "action" => 2,
    "params" => 1
    )
);
//Define a maintenance schedule controller route
$router->add("/maintenance-schedule/:action", array(
        "controller" => "maintenanceschedule",
        "action" => 1
    )
);
