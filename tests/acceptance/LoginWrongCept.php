<?php
$I = new WebGuy($scenario);
$I->wantTo('test wrong password/username during login');
$I->amOnPage("/");
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->amOnPage("/login");
$I->wantToTest("empty username and password empty");
$I->fillField('Username','');
$I->fillField('Password','');
$I->seeElement('input[type=submit]');
$I->doubleClick('input[type=submit]');
$I->see("Username and Password should be not empty");
$I->wantToTest("wrong username and wrong password");
$I->fillField('Username','sdffdafdfsdf');
$I->fillField('Password','sdfdsfdsfdsf');
$I->seeElement('input[type=submit]');
$I->doubleClick('input[type=submit]');
$I->see("Wrong username or/and password");
$I->wantToTest("correct username and wrong password");
$I->fillField('Username','valentin');
$I->fillField('Password','sdfdsfdsfdsf');
$I->seeElement('input[type=submit]');
$I->doubleClick('input[type=submit]');
$I->see("Wrong username or/and password");


