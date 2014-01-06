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
