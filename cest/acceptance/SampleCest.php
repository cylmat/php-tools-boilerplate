<?php

/**
 * @see https://codeception.com/docs/modules/PhpBrowser
 */
class SampleCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // home
    // -PHP 7.3.27-9+ubuntu ... +1 Development Server- 
    public function homePage(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->seeCurrentUrlMatches('~^/$~');
        $I->see('Server');
    }
}
