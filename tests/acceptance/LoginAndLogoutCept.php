<?php
$I = new WebGuy\MemberSteps($scenario);
$I->am('Client');
$I->wantTo('See and click login link');
$I->amOnPage('/');
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->login('valentin', '123');
$I->see("Welcome Валентин Ан");
$I->seeLink('Account');
$I->wantTo("Logout");
$I->seeLink("Logout");
$I->doubleClick("#logout");
$I->amGoingTo("Home page");
$I->dontSeeLink("Account");

