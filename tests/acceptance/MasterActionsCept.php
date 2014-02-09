<?php
$I = new WebGuy\MemberSteps($scenario);
$I->am('master');
$I->login('dima', '123');
$I->see("Welcome Дима Д");
$I->wantTo('add a new client');
$I->doubleClick("a[href='/clients/new']");
$I->seeElement("form.form-create-client");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->fillField("username", "test123");
$I->fillField("password", "123");
$I->fillField("fullname", "test 123");
$I->fillField("contact_phone", "123-123-123");
$I->doubleClick(".form-create-client input[type=submit]");
$I->see("Client 'test123' was created successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->wantTo('add a new car');
$I->doubleClick("a[href='/cars/new']");
$I->seeElement("form.form-create-car");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->fillField("vin", "testcarvin");
$I->fillField("registration_number", "regnumber");
$I->fillField("username", "anvar");
$I->selectOption("model_id","Matiz Best 2011");
$I->fillField("year", "2011");
$I->fillField("milage", "20000");
$I->fillField("daily_milage", "20");
$I->doubleClick(".form-create-car input[type=submit]");
$I->see("Car 'TESTCARVIN' was created successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->wantTo('add a new provided service');
$I->doubleClick("a[href='/providedservices/new']");
$I->seeElement("form.form-create-provided-service");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->fillField("vin", "KLAF69ZEV012345");
$I->fillField("milage", "20000");
$I->fillField("start_date", "12.03.2014");
$I->doubleClick(".form-create-provided-service input[type=submit]");
$I->see("The provided service for car 'KLAF69ZEV012345' was created successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->wantTo('add a new car model');
$I->doubleClick("a[href='/carmodels/new']");
$I->seeElement("form.form-create-car-model");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->fillField("model", "TESTMODEL");
$I->doubleClick(".form-create-car-model input[type=submit]");
$I->see("Car model 'TESTMODEL' was created successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->wantTo('add a new car brand');
$I->doubleClick("a[href='/carbrands/new']");
$I->seeElement("form.form-create-car-brand");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->fillField("brand", "TESTBRAND");
$I->doubleClick(".form-create-car-brand input[type=submit]");
$I->see("Car brand 'TESTBRAND' was created successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->wantTo('add edit provided service information');
$I->doubleClick("a[href='/providedservices/edit/1']");
$I->seeElement("form.form-edit-provided-service");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->fillField("vin", "FGFF69ZEV017877");
$I->fillField("milage", "30000");
$I->selectOption("service_id","Свечи зажигания");
$I->selectOption("master_id","Дима Д");
$I->fillField("start_date", "28.12.2013");
$I->doubleClick(".form-edit-provided-service input[type=submit]");
$I->see("The provided service with id '1' was updated successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));

