<?php

use Behat\Gherkin\Node\TableNode;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    /**
     * @Given i am on the home page
     */
    public function iAmOnTheHomePage(TableNode $node)
    {
        $this->amOnPage("/");
        #var_dump($node->getRows());
        #throw new \PHPUnit\Framework\IncompleteTestError("Step `i am on the home page` is not defined");
    }

    /**
     * @When i read the output
     */
    public function iReadTheOutput()
    {
        #throw new \PHPUnit\Framework\IncompleteTestError("Step `i read the output` is not defined");
    }

    /**
     * @Then i should see the server data :txt
     */
    public function iShouldSeeTheServerData($txt)
    {
        $this->see('Server');
        #var_dump($txt);
        #throw new \PHPUnit\Framework\IncompleteTestError("Step `i should see the server data` is not defined");
    }
}
