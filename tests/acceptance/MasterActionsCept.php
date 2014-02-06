<?php
$I = new WebGuy\MemberSteps($scenario);
$I->am('master');
$I->login('dima', '123');
$I->see("Welcome Дима Д");
$I->wantTo('add a new client');
$I->seeLink("Add Client");
$I->doubleClick("a[href='/clients/new']");
$I->seeElement("form.form-create-client");
$I->fillField("username", "test123");
$I->fillField("password", "123");
$I->fillField("fullname", "test 123");
$I->fillField("contact_phone", "123-123-123");
$I->doubleClick(".form-create-client input[type=submit]");
$I->see("Client 'test123' was created successfully");
$I->wantTo('add a new car');
$I->seeLink("Add Car");
$I->doubleClick("a[href='/cars/new']");
$I->seeElement("form.form-create-car");
$I->fillField("vin", "testcarvin");
$I->fillField("registration_number", "regnumber");
$I->fillField("username", "anvar");
$I->selectOption("model_id","Matiz Best 2011");
$I->fillField("year", "2011");
$I->fillField("milage", "20000");
$I->fillField("daily_milage", "20");
$I->doubleClick(".form-create-car input[type=submit]");
$I->see("Car 'TESTCARVIN' was created successfully");

