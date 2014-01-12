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
//Add wait to process ajax response
$I->wait(50);
$I->see("(99890) 124-23-22");
$I->wantTo('update my email');
$I->seeElement("span.contactemail");
$I->doubleClick("span.contactemail");
$I->fillField("contactemail",'mynew@email.com');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("mynew@email.com");
$I->wantTo('update my info');
$I->seeElement("span.moreinfo");
$I->doubleClick("span.moreinfo");
$I->fillField("moreinfo",'I am adding more info');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("I am adding more info");
$I->wantTo('update my car milage');
$I->seeElement("span.milage");
$I->doubleClick("span.milage");
$I->fillField("milage",'51000');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("51000");
$I->wantTo('update my car daily milage');
$I->seeElement("span.dailymilage");
$I->doubleClick("span.dailymilage");
$I->fillField("dailymilage",'15');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("15");



