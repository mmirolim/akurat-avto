<?php
$I = new WebGuy($scenario);
$I->wantTo('find car info from car VIN');
$I->am("Employee");
$I->wantTo('login and use QR scanner');
$I->amOnPage('/');
$I->seeLink("Login");
$I->click("Login");
$I->amGoingTo("To login page");
$I->amOnPage("/login");
$I->fillField('Username','mahmud');
$I->fillField('Password','123');
$I->seeElement('input[type=submit]');
$I->doubleClick('input[type=submit]');
$I->see("Welcome Махмуд М");
$I->see("Find car by QR Code");
//Let assume button clicked, it stated qr scanner app which set correct url in browser
$I->amOnPage("/cars/findByVin/VIN-AZAF69ZEV016666-VIN");
$I->see("VIN AZAF69ZEV016666");

