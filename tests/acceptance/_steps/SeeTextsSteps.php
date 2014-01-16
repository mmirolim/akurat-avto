<?php
namespace WebGuy;


class SeeTextsSteps extends \WebGuy
{
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