<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Laracasts\Behat\Context\DatabaseTransactions;
use Laracasts\Behat\Context\Migrator;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use DatabaseTransactions;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I add a new customer :firstName :lastName
     */
    public function iAddANewCustomer($firstName, $lastName)
    {
        $this->visit('customers/create');

        $this->fillField('first_name', $firstName);
        $this->fillField('last_name', $lastName);

        $this->pressButton('Add');
    }

    /**
     * @When I update the last name of :id to :lastName
     */
    public function iUpdateTheLastNameOfTo($id, $lastName)
    {
        $this->visit('customers/'.$id.'/edit');

        $this->fillField('last_name', $lastName);

        $this->pressButton('Update');
    }

    /**
     * @Then I should see :rowCount customers
     */
    public function iShouldSeeCustomers($rowCount)
    {
        $table = $this->getSession()->getPage()->find('css', 'body > div > div:nth-child(3) > div > table');
        if (!$table) {
            throw new \Exception('Cannot find a table!');
        }

        $rows = $table->findAll('css', 'tbody > tr');

        if ($rowCount != count($rows)) {
            throw new \Exception('not the right number! - I see '.count($rows));
        }
    }

    /**
     * @Then I delete the second customer
     */
    public function iDeleteTheSecondCustomer()
    {
        $btn = $this->getSession()->getPage()->find('css', 'body > div > div:nth-child(3) > div > table > tbody > tr:nth-child(2) > td:nth-child(2) > form > button.btn.btn-danger.btn-xs.confirm');
        $btn->click();
    }

    /**
     * @Then I merge duplicates
     */
    public function iMergeDuplicates()
    {
        $this->visit('customers/duplicates');
        $this->clickLink('view profile');
        $this->checkOption('profiles[]');

        $this->pressButton('Merge Selected');
    }
}
