<?php
$I = new WebGuy\MemberSteps($scenario);
$I->wantTo('test wrong password/username during login');
$I->amOnPage("/");
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->wantToTest("empty username and password empty");
$I->login('', '');
$I->see("Username and Password should be not empty");
$I->wantToTest("wrong username and wrong password");
$I->login('sdfsdsdfa', 'sdfsdfsdfs');
$I->see("Wrong username or/and password");
$I->wantToTest("correct username and wrong password");
$I->login('valentin', '123sdfsdfds');
$I->see("Wrong username or/and password");


