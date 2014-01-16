<?php
//Model validation not implemented yet
//TODO refactor test after validaton implemented
$I = new WebGuy\MemberSteps($scenario);
$I->am("Client");
$I->wantTo('login and update my data');
$I->amOnPage('/');
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->login('valentin', '123');
$I->see("Welcome Валентин Ан");
$I->seeLink('Account');
$I->seeElement("span.contact_phone");
$I->doubleClick("span.contact_phone");
$I->fillField("contact_phone",'(99890) 124-23-22');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Contact phone updated to (99890) 124-23-22");
$I->wantTo('update my email');
$I->seeElement("span.contact_email");
$I->doubleClick("span.contact_email");
$I->fillField("contact_email",'mynew@email.com');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Contact Email updated to mynew@email.com");
$I->wantTo('update my info');
$I->seeElement("span.more_info");
$I->doubleClick("span.more_info");
$I->fillField("more_info",'I am adding more info');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Personal information updated to I am adding more info");
$I->wantTo('update my car milage');
$I->seeElement("span.milage");
$I->doubleClick("span.milage");
$I->fillField("milage",'51000');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Milage updated to 51000");
$I->wantTo('update my car daily milage');
$I->seeElement("span.daily_milage");
$I->doubleClick("span.daily_milage");
$I->fillField("daily_milage",'15');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Daily milage updated to 15");
$I->wantTo('update notify status');
$I->seeElement("span.notify");
$I->doubleClick("span.notify");
$I->doubleClick("#notify");
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Notification status updated to Yes");
$I->wantTo('update my password');
$I->seeElement("span.password");
$I->doubleClick("span.password");
$I->fillField("Your current password",'123');
$I->fillField("new_pass",'1234');
$I->doubleClick(".inline-update-button");
//Add wait to process ajax response
$I->wait(50);
$I->see("Your password updated Successfully");



