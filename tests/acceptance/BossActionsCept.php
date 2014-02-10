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
$I->wantTo("delete provided service");
$I->doubleClick("a[href='/providedservices/confirm/3']");
$I->seeElement("form.form-delete-provided-service");
$I->doubleClick(".form-delete-provided-service input[type=submit]");
$I->see("The provided service with id '3' was deleted successfully");
$I->dontSeeTexts(array('Notice', 'Warning', 'Error'));

