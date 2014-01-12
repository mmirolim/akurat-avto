<?php
//Model validation not implemented yet
//TODO refactor test after validaton implemented
$I = new WebGuy($scenario);
$I->am("Client");
$I->wantTo('login and update my data');
$I->amOnPage('/');
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->amOnPage("/login");
$I->fillField('Username','valentin');
$I->fillField('Password','1234');
$I->seeElement('input[type=submit]');
$I->doubleClick('input[type=submit]');
$I->see("Welcome Валентин Ан");
$I->seeLink('Account');
$I->seeElement("span.contactphone");
$I->doubleClick("span.contactphone");
$I->fillField("contactphone",'(99890) 124-23-22');
$I->doubleClick(".inline-update-button");
$I->see("(99890) 124-23-22");


