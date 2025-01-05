<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;

class AddFeatureContext extends MinkContext implements Context
{
    private KernelInterface $kernel;
    private KernelBrowser $client;

    public function __construct(KernelInterface $kernel, KernelBrowser $client)
    {
        $this->kernel = $kernel;
        $this->client = $client;
    }

    /**
     * @Then the application's kernel should use :expected environment
     */
    public function kernelEnvironmentShouldBe(string $expected): void
    {
        if ($this->kernel->getEnvironment() !== $expected) {
            throw new \RuntimeException();
        }
    }

    #[Given('I navigate to :url')]
    public function iNavigateTo($url): void
    {
        $this->visitPath($url);
    }

    #[When('I press :button')]
    public function iPress($button)
    {
        /*$row = $this->getSession()->getPage()->find('xpath', "//tr[td[contains(text())]]");
        $buttonElement = $row->find('named', ['link_or_button', $button]);

        if (!$buttonElement) {
            throw new \Exception("Button '$button' not found");
        }

        $buttonElement->click();*/
        $this->pressButton($button);
    }

    #[When('| I fill in with :title and :content')]
    public function iFillInWith($title, $content): void
    {
        $this->fillField('title', $title);
        $this->fillField('content', $content);
    }

    #[When('I click :button')]
    public function iClick($button)
    {
        /*$row = $this->getSession()->getPage()->find('xpath', "//tr[td[contains(text())]]");
        $buttonElement = $row->find('named', ['link_or_button', $button]);

        if (!$buttonElement) {
            throw new \Exception("Button '$button' not found");
        }

        $buttonElement->click();*/
        $this->pressButton($button);
    }

    #[Then('I should see :arg1')]
    public function iShouldSee($arg1): void
    {
        $this->assertPageContainsText($arg1);
    }

    #[Then('I should not see :arg1')]
    public function iShouldNotSee($arg1): void
    {
        $this->assertPageNotContainsText($arg1);
    }
}