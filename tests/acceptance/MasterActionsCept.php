<?php
$I = new WebGuy\MemberSteps($scenario);
$I->am('master');
$I->wantTo('add a new client');
$I->login('dima', '123');
$I->see("Welcome Дима Д");
$I->seeLink("Add Client");
$I->doubleClick("a[href='/clients/new']");
$I->seeElement("form.form-create-client");
$I->fillField("username", "test123");
$I->fillField("password", "123");
$I->fillField("fullname", "test 123");
$I->fillField("contact_phone", "123-123-123");
$I->doubleClick(".form-create-client input[type=submit]");
$I->see("Client 'test123' was created successfully");

