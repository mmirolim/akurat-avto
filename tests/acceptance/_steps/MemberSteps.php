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

    function dontSeeTexts (array $texts)
    {
        $I = $this;
        foreach ($texts as $key => $text) {
            if (!is_int($key)) {
                $I->dontSee($text, $key);
            } else {
                $I->dontSee($text);
            }
        }

    }

    function seeTexts (array $texts)
    {
        $I = $this;
        foreach ($texts as $key => $text) {
            if (!is_int($key)) {
                $I->see($text, $key);
            } else {
                $I->see($text);
            }
        }

    }

}