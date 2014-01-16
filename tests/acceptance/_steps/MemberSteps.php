<?php
namespace WebGuy;

class MemberSteps extends \WebGuy
{
    function login($username, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->fillField(\LoginPage::$usernameField, $username);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->doubleClick(\LoginPage::$loginButton);

    }
    function logout()
    {
        $I = $this;

    }

}