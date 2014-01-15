<?php
$I = new WebGuy($scenario);
$I->am('Client');
$I->wantTo('See and click login link');
$I->amOnPage('/');
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->amOnPage("/login");
$I->fillField('Username','valentin');
$I->fillField('Password','123');
$I->seeElement('input[type=submit]');
$I->doubleClick('input[type=submit]');
$I->see("Welcome Валентин Ан");
$I->seeLink('Account');
$I->wantTo("Logout");
$I->seeLink("Logout");
$I->doubleClick("#logout");
$I->amGoingTo("Home page");
$I->dontSeeLink("Account");

