<?php
$I = new WebGuy\MemberSteps($scenario);
$I->am('employee');
$I->wantTo('Search client by username');
$I->login('mahmud', '123');
$I->see("Welcome Махмуд М");
$I->fillField("username", "anvar");
$I->doubleClick(".form-search-client input[type=submit]");
$I->see("(99893) 567-12-32");


