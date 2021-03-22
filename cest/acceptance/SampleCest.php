<?php

class SampleCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function homePage(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Apache');
    }
}
