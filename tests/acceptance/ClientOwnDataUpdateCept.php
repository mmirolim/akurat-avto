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
$I->see("contactphone updated to (99890) 124-23-22");
$I->wantTo('update my email');
$I->seeElement("span.contactemail");
$I->doubleClick("span.contactemail");
$I->fillField("contactemail",'mynew@email.com');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("contactemail updated to mynew@email.com");
$I->wantTo('update my info');
$I->seeElement("span.moreinfo");
$I->doubleClick("span.moreinfo");
$I->fillField("moreinfo",'I am adding more info');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("moreinfo updated to I am adding more info");
$I->wantTo('update my car milage');
$I->seeElement("span.milage");
$I->doubleClick("span.milage");
$I->fillField("milage",'51000');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("milage updated to 51000");
$I->wantTo('update my car daily milage');
$I->seeElement("span.dailymilage");
$I->doubleClick("span.dailymilage");
$I->fillField("dailymilage",'15');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("dailymilage updated to 15");
$I->wantTo('update notify status');
$I->seeElement("span.remind");
$I->doubleClick("span.remind");
$I->doubleClick("#notify");
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("remind updated to Yes");
$I->wantTo('update my password');
$I->seeElement("span.password");
$I->doubleClick("span.password");
$I->fillField("Your current password",'1234');
$I->fillField("newpass",'123');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("password updated Successfully");



