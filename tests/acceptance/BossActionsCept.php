<?php
$I = new WebGuy\MemberSteps($scenario);
$I->am('boss');
$I->login('mirodil', '123');
$I->see("Welcome Миродил Мирзахмедов");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
$I->wantTo('add a new service');
$I->doubleClick("a[href='/carservices/new']");
$I->seeElement("form.form-create-car-service");
$I->fillField("service", "TESTSERVICE");
$I->doubleClick(".form-create-car-service input[type=submit]");
$I->see("Car service 'TESTSERVICE' was created successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));
