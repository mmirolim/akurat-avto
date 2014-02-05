<?php
//Create the router
$router = new \Phalcon\Mvc\Router();

//Define a "/account" route
$router->add("/client/:params", array(
    "controller" => "account",
    "action" => "client",
    "params" => 1
    )
);
//Define a "/account" route
$router->add("/employee/:params", array(
        "controller" => "account",
        "action" => "employee",
        "params" => 1
    )
);
//Define a "/account" route
$router->add("/master/:params", array(
        "controller" => "account",
        "action" => "master",
        "params" => 1
    )
);
//Define a "/account" route
$router->add("/boss/:params", array(
        "controller" => "account",
        "action" => "boss",
        "params" => 1
    )
);
//Define a "/account" route
$router->add("/admin/:params", array(
        "controller" => "account",
        "action" => "admin",
        "params" => 1
    )
);
//Define a maintenance schedule controller route
$router->add("/maintenance-schedule/:action", array(
        "controller" => "maintenanceschedule",
        "action" => 1
    )
);
